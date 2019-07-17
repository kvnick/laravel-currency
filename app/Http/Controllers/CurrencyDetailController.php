<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\Currency\CurrencyService;

class CurrencyDetailController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $model)
    {
        $this->currencyService = $model;
    }

    public function index($id = null)
    {
        if ($id == null) {
            abort(404);
        }

        $currency = $this->currencyService->getCurrencyByName($id);

        if (!is_array($currency) || is_null($currency)) {
            abort(404);
        }

        $currency     = $currency[strtoupper($id)];
        $currencyCode = $currency['@ID'];

        $title             = 'Курс ' . $currency['Name'];
        $metaDescription   = 'Курс ' . $currency['Name'] . ' и график ' . $currency['Name'];

        $startDate   = \Carbon\Carbon::now()->subYears(10)->subYear()->format('d-m-Y');
        $endDate     = \Carbon\Carbon::now()->format('d-m-Y');
        $weekAgo     = \Carbon\Carbon::now()->subDays(7)->format('d-m-Y');

        return view('currency.detail',[
            'title'            => $title,
            'metaDescription'  => $metaDescription,
            'currency'         => $currency,
            'currencyCode'     => $currencyCode,
            'dates'            => $this->getDates(),
            'chartStartDate'   => $startDate,
            'chartEndDate'     => $endDate,
            'detailCurrency'   => $this->getDinamicDetail($weekAgo, $endDate, $currencyCode)
        ]);
    }

    /**
     * Get dates for graph

     * @return array
     */
    private function getDates()
    {
        return $this->currencyService->getDates();
    }

    /**
     * Get dinamic values for currency
     *
     * @param String $dateStart
     * @param String $dateEnd
     * @return Array
     */
    private function getDinamicDetail($dateStart, $dateEnd, $id = null)
    {
        if (is_null($id)) {
            return false;
        }

        // if id is null, then we get values for $ => (american dollar)
        $data = $this->currencyService->getCurrencies('dinamic', NULL, array($dateEnd, $dateStart, $id));

        return $data;
    }
}
