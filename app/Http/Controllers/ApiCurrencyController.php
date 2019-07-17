<?php

namespace App\Http\Controllers;

use App\Service\Currency\CurrencyService;
use Illuminate\Http\Request;

class ApiCurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Get dinamic currency values
     *
     * @param string $date_end
     * @param string $date_start
     * @return json
     */
    public function getDinamic($date_start, $date_end, $currencyCode = null)
    {
        $currencyCode = ($currencyCode == null) ? "" : $currencyCode;

        $data = $this->currencyService->getCurrencies('dinamic', NULL, array($date_end, $date_start, $currencyCode));

        return response()->json($data);
    }

    /**
     * Get currency

     * @param type|null $type
     * @return type
     */
    public function getCurrency($type = NULL, $date_req = NULL, $currencyCode = NULL)
    {
        if (is_null($type) || empty(trim($type)) || $type == false)  {
            return response()->json([
                'go' => 'away'
            ]);
        }

        $data = $this->currencyService->getCurrencies($type, array($currencyCode), array($date_req));

        if (!$data) {
            return response()->json([
                'data' => 'is empty'
            ]);
        }

        return response()->json($data);
    }

    /**
     * Get currency codes
     *
     * @param type|null $code
     * @return type
     */
    public function getCodes($code = null)
    {
        return response()->json($this->currencyService->getCodes($code));
    }
}
