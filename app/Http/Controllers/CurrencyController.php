<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service\Currency\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $dailyCurrencies = $this->currencyService->getCurrencies();
        $indexCurrencies = $this->currencyService->getCurrencies('daily', ['USD', 'EUR']);

        $dates = $this->currencyService->getDates();

        return view('currency.index', [
            'title' => 'Курсы валют с ЦБ РФ',
            'indexCurrencies' => $indexCurrencies,
            'dates' => $dates,
            'dailyCurrencies' => $dailyCurrencies,
            'chartStartDate'   => Carbon::now()->subYears(10)->subYear()->format('d-m-Y'),
            'chartEndDate'     => Carbon::now()->format('d-m-Y'),
        ]);
    }

    public function about()
    {
        return view('currency.about');
    }

    public function list()
    {
        $dailyCurrencies = $this->currencyService->getCurrencies();

        return view('currency.all', [
            'currencies'  => $dailyCurrencies
        ]);
    }
}
