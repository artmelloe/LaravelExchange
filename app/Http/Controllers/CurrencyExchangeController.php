<?php

namespace App\Http\Controllers;

use App\Misc\Helper;
use App\Models\Configuration;
use App\Models\Exchange;
use App\Services\CurrencyExchangeService;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CurrencyExchangeController extends Controller
{
    public function index(CurrencyExchangeService $currencyExchangeService) :View
    {
        $exchange_available = $currencyExchangeService->getDefaultAvailable();
        $configuration = Configuration::first();
        $exchange_total = Exchange::orderByDesc('created_at')->get();

        return view('index', compact('exchange_available', 'configuration', 'exchange_total'));
    }

    public function store(CurrencyExchangeService $currencyExchangeService, Request $request) :RedirectResponse
    {
        $this->storeConfiguration($request);

        $income_currency = $request->input('income_currency');
        $amount_exchange = $request->input('amount_exchange');
        $payment_method = $request->input('payment_method');

        $result = $currencyExchangeService->getExchange($income_currency, $amount_exchange, $payment_method);

        $this->storeExchange($result);

        return Redirect::route('index')->with('result', $result);
    }

    private function storeConfiguration(Request $request) :Void
    {
        $configuration = Configuration::first();

        $configuration->boleto_fee = Helper::percentageToFloat($request->input('boleto_fee'));
        $configuration->credit_card_fee = Helper::percentageToFloat($request->input('credit_card_fee'));
        $configuration->fee_amount_less = Helper::percentageToFloat($request->input('fee_amount_less'));
        $configuration->fee_amount_less_value = $request->input('fee_amount_less_value');
        $configuration->fee_amount_greater = Helper::percentageToFloat($request->input('fee_amount_greater'));
        $configuration->fee_amount_greater_value = $request->input('fee_amount_greater_value');

        $configuration->save();
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

    public function submitEmail(EmailService $emailService, Request $request) :RedirectResponse
    {
        $exchange = Exchange::orderByDesc('created_at')->first();

        $email = $request->input('email');
        $subject = 'Currency Exchange';

        $message = 'Here is your exchange result:<br><br>';
        $message .= '<b>Origin currency:</b> '.$exchange->origin_currency.'<br>';
        $message .= '<b>Income currency:</b> '.$exchange->income_currency.'<br>';
        $message .= '<b>Amount exchange:</b> '.Helper::currencyFormat($exchange->amount_exchange).'<br>';
        $message .= '<b>Payment method:</b> '.Helper::capitalize($exchange->payment_method).'<br>';
        $message .= '<b>Current currency:</b> '.Helper::currencyFormat($exchange->current_currency, false).'<br>';
        $message .= '<b>Exchange total:</b> '.Helper::currencyFormat($exchange->exchange_total).'<br>';
        $message .= '<b>Payment fee:</b> '.Helper::currencyFormat($exchange->payment_fee).'<br>';
        $message .= '<b>Exchange fee:</b> '.Helper::currencyFormat($exchange->exchange_fee).'<br>';
        $message .= '<b>Exchange without fees:</b> '.Helper::currencyFormat($exchange->exchange_without_fees).'<br>';

        $emailService->send($email, $subject, $message);

        return Redirect::route('index')->with('submit_email_success', 'Your email has been sent!');
    }
}
