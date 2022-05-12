<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeRequest;
use App\Models\Exchange;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CurrencyExchangeController extends Controller
{
    public function getExchange(CurrencyExchangeService $currencyExchangeService, ExchangeRequest $request) :JsonResponse
    {
        $income_currency = $request->input('income_currency');
        $amount_exchange = $request->input('amount_exchange');
        $payment_method = $request->input('payment_method');

        $result = $currencyExchangeService->getExchange($income_currency, $amount_exchange, $payment_method);

        $this->storeExchange($result);

        return response()->json([
            $result
        ], Response::HTTP_OK);
    }

    private function storeExchange(Array $result) :Void
    {
        $exchange = new Exchange;

        $exchange->origin_currency = $result['originCurrency'];
        $exchange->income_currency = $result['incomeCurrency'];
        $exchange->amount_exchange = $result['amountExchange'];
        $exchange->payment_method = $result['paymentMethod'];
        $exchange->current_currency = $result['currentCurrency'];
        $exchange->exchange_total = $result['exchangeTotal'];
        $exchange->payment_fee = $result['paymentFee'];
        $exchange->exchange_fee = $result['exchangeFee'];
        $exchange->exchange_without_fees = $result['exchangeWithoutFees'];

        $exchange->save();
    }

    public function getDefaultAvailable(CurrencyExchangeService $currencyExchangeService) :JsonResponse
    {
        $result = $currencyExchangeService->getDefaultAvailable();

        return response()->json([
            $result
        ], Response::HTTP_OK);
    }
}
