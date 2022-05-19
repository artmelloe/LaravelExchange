<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\ExchangeRequest;
use App\Models\Exchange;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CurrencyExchangeController extends Controller
{
    /**
    * @OA\Get(
    *     path="/exchange/available",
    *     tags={"Currency Exchange"},
    *     summary="Check the currencies available to exchange",
    *     operationId="available",
    *      security={
    *          {"bearer": {}}
    *      },
    *     @OA\Response(
    *         response=200,
    *         description="Success"
    *     ),
    *     @OA\Response(
    *        response=401,
    *        description="Unauthenticated"
    *     ),
    * )
    */

    public function getDefaultAvailable(CurrencyExchangeService $currencyExchangeService) :JsonResponse
    {
        $result = $currencyExchangeService->getDefaultAvailable();

        return response()->json([
            $result
        ], Response::HTTP_OK);
    }

        /**
    * @OA\Post(
    *      path="/exchange",
    *      tags={"Currency Exchange"},
    *      summary="Exchange the currencies",
    *      operationId="exchange",
    *      security={
    *          {"bearer": {}}
    *      },
    *      @OA\Parameter(
    *          name="income_currency",
    *          in="query",
    *          required=true,
    *          example="USD",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="amount_exchange",
    *          in="query",
    *          required=true,
    *          example="5000",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="payment_method",
    *          in="query",
    *          required=true,
    *          example="boleto",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Success"
    *      ),
    *       @OA\Response(
    *          response=401,
    *          description="Unauthenticated"
    *      ),
    *       @OA\Response(
    *          response=422,
    *          description="Unprocessable Content"
    *      )
    * )
    */

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

        /**
    * @OA\Get(
    *     path="/exchange/history",
    *     tags={"Currency Exchange"},
    *     summary="Check the exchange history",
    *     operationId="history",
    *      security={
    *          {"bearer": {}}
    *      },
    *     @OA\Response(
    *         response=200,
    *         description="Success"
    *     ),
    *     @OA\Response(
    *        response=401,
    *        description="Unauthenticated"
    *     ),
    * )
    */

    public function getExchangeHistory()
    {
        $result = Exchange::orderByDesc('created_at')->get();

        return response()->json(
            $result
        , Response::HTTP_OK);
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
}
