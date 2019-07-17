<?php

namespace App\Service\Currency;

use Cache;
use Carbon\Carbon;
use Log;
use Nathanmac\Utilities\Parser\Facades\Parser;

class CurrencyService
{
    /**
     * @var url of query to get currencies
     */
    private $dailyUrl = "http://www.cbr.ru/scripts/XML_daily.asp";

    /**
     * @var url of query to get currencies for tomorrow
     */
    private $dailyYesterdayUrl = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=";

    /**
     * @var url of dinamic currencies
     */
    // private $dinamicUrl = "http://www.cbr.ru/scripts/XML_dynamic.asp?VAL_NM_RQ=R01235";
    private $dinamicUrl = "http://www.cbr.ru/scripts/XML_dynamic.asp";

    /**
     * @var currency list numbers
     */
    private $currenciesCodeListUrl = "http://www.cbr.ru/scripts/XML_val.asp?d=0";

    /**
     * @var date
     */
    private $date;

    /**
     * Variable for currency codes
     * @var array
     */
    private $codes = [];

    public function __construct()
    {
        $this->date = [
            'day' => [
                'start' => (new Carbon('first day of this month'))->day,
                'end' => (new Carbon('last day of this month'))->day
            ],
            'month' => [
                'start' => Carbon::now()->month,
                'end' => Carbon::now()->month
            ],
            'year' => [
                'start' => Carbon::now()->year,
                'end' => Carbon::now()->year
            ]
        ];

        // get yesterday date format
        $this->yesterdayDate = (new Carbon('yesterday'))->format('d/m/Y');

        // set yesterday url for request
        $this->dailyYesterdayUrl = $this->dailyYesterdayUrl.$this->yesterdayDate;

        $this->setCurrencyCodes();
    }

    /**
     * Make a query to url with cache
     *
     * @param type $method
     * @param type $url
     * @param type $param
     *
     * @return type
     */
    public function query($url = null, array $params = null)
    {
        $url = $url ? $url : $this->url;

        try {
            $client = new \GuzzleHttp\Client();

            if (is_null($url)) {
                throw new Exception("The request url shouldn't be empty");
            }

            // todo: get list of currency value number
            $res = $client->request('GET', $url,
                $params ? ['query' => $params] : []
            );

            if ($res->getStatusCode() !== 200) {
                throw new \HttpException();
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());

            abort(500);
        }

        // all urls return xml files
        // Parser::xml use simplexml_load_string
        // see: http://php.net/manual/ru/function.simplexml-load-string.php
        return Parser::xml($res->getBody());
    }

    /**
     * Get parsed currencies
     * @param type|string $type
     * @param type|null $currencies
     * @return array
     */
    public function getCurrencies($type = 'daily', $currencies = NULL, array $params = NULL)
    {
        if (!in_array($type, ['daily', 'dinamic'])) {
            return FALSE;
        }

        $result = array();

        if ($type == 'daily') {
            if (is_null($params[0]) || empty($params[0])) {
                $newParams = [
                    'date_req' => Carbon::now()->format('d/m/Y')
                ];
            } else {
                $newParams = [
                    'date_req' => Carbon::parse($params[0])->format('d/m/Y')
                ];
            }

            $result = $this->parseDailyCurrencies($currencies, $newParams);

        } elseif ($type == 'dinamic') {
            /*
            * if params is null, set first date to year ago
            * and second to today
            */
            if (is_null($params[2]) || empty($params[2])) {
                $params[2] = 'R01235';
            }

            if (!is_null($params)) {
                $newParams = [
                    'date_req1' => Carbon::parse($params[1])->format('d/m/Y'),
                    'date_req2' => Carbon::parse($params[0])->format('d/m/Y'),
                    'VAL_NM_RQ' => $params[2]
                ];
            } else {
                $newParams = [
                    'date_req1' => Carbon::now()->subYear()->format('d/m/y'),
                    'date_req2' => Carbon::now()->format('d/m/y'),
                    'VAL_NM_RQ' => 'R01235'
                ];
            }

            $result = $this->parseDinamicCurrencies($currencies, $newParams);
        }

        return $result;
    }

    /**
     * Get currency codes

     * @return array
     */
    public function getCodes($code = null)
    {
        $result = array();

        $code = (is_null($code)) ? null : $code;

        $result = $this->parseCurrenciesCodes($code);

        return $result;
    }

    public function setCurrencyCodes()
    {
        $data = [];

        $this->codes[] = $data;
    }
    /**
     * Get currency by name (example: USD, EUR)
     *
     * @param type|null $name
     * @return type
     */
    public function getCurrencyByName($name = null)
    {
        if (is_null($name)) {
            return null;
        }

        $name = strtoupper($name);

        $currencies = $this->getCurrencies('daily', [$name]);

        if (empty($currencies) || is_null($currencies)) {
            return null;
        }

        return $currencies;
    }

    /**
     * Parse dinamic data
     *
     * @param type|null $currencies
     * @param type|null $params
     * @return type
     */
    private function parseDinamicCurrencies($currencies = NULL, $params = NULL)
    {
        $data = $this->query($this->dinamicUrl, $params);

        $result = [];

        if (!empty($data['Record'])) {
            foreach ($data['Record'] as $key => $value) {
                $result[] = [
                    'date' => $value['@Date'],
                    'value' => (float)number_format(preg_replace('/,/i', '.', $value['Value']), 4, '.', '')
                ];
            }
        }

        return $result;
    }


    /**
     * Parse daily currencies
     *
     * @param type|null $currencies
     * @return array
     */
    private function parseDailyCurrencies($currencies = NULL, $params = NULL)
    {
        $result = [];
        $data = $this->query($this->dailyUrl, $params);

        if (!empty($data['Valute'])) {
            foreach ($data['Valute'] as $key => $value) {
                if (!is_null($currencies) && is_array($currencies)) {
                    if (in_array($value['CharCode'], $currencies)) {
                        $result[$value['CharCode']] = $value;
                    }
                } else {
                    $result[$value['CharCode']] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * Parse code of currencies
     * @param type|string $value
     * @return type
     */
    private function parseCurrenciesCodes($code)
    {
        $result = [];

        $data = $this->query($this->currenciesCodeListUrl);

        if (!is_null($code)) {
            foreach ($data['Item'] as $key => $value) {
                if ($code == $value['@ID']) {
                    $result = $value;
                }
            }
        }
        else {
            $result = $data['Item'];
        }

        return $result;
    }

    public function getDates()
    {
        return [
            'неделя' => [
                'count' => 7,
                'period' => 'DD'
            ],
            'месяц' => [
                'count' => 1,
                'period' => 'MM'
            ],
            '3 месяца' => [
                'count' => 3,
                'period' => "MM"
            ],
            'полгода' => [
                'count' => 6,
                'period' => "MM"
            ],
            'год' => [
                'count' => 1,
                'period' => "YYYY"
            ],
            '2 года' => [
                'count' => 2,
                'period' => "YYYY"
            ],
            'Все' => [
                'count' => NULL,
                'period' => "MAX"
            ],
        ];
    }
}
