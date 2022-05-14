<?php

namespace App\Services;

use App\Misc\Helper;
use App\Models\Configuration;
use GuzzleHttp\Client;

class CurrencyExchangeService
{
    private const DEFAULT_CURRENCY_SIGN = 'BRL';
    private const DEFAULT_CURRENCY_NAME = 'Real Brasileiro';

    public const BOLETO_PAYMENT_METHOD = 'boleto';
    public const CREDIT_CARD_PAYMENT_METHOD = 'credit_card';

    private function initialize(String $params) :Array
    {
        $url = 'http://economia.awesomeapi.com.br/';
        $client = new Client;
        $client = $client->get($url.$params);
        $response = json_decode($client->getBody(), true);

        return $response;
    }

    private function calculateFees($response, Float $amount_exchange, String $payment_method) :Array
    {
        $configuration = Configuration::first();

        $data = reset($response);
        $income_currency = $data['code'];
        $current_currency = Helper::numberFormat($data['ask']);

        $payment_fee = $amount_exchange * match ($payment_method) {
            self::BOLETO_PAYMENT_METHOD => $configuration->boleto_fee,
            self::CREDIT_CARD_PAYMENT_METHOD => $configuration->credit_card_fee
        };

        $exchange_fee = $amount_exchange * match (true) {
            $amount_exchange > $configuration->fee_amount_greater_value => $configuration->fee_amount_greater,
            $amount_exchange <= $configuration->fee_amount_less_value => $configuration->fee_amount_less,
            default => 0 // No exchange fee applied!
        };

        $exchange_without_fees = $amount_exchange - ($payment_fee + $exchange_fee);
        $exchange_total = $exchange_without_fees / $current_currency;

        return [
            'originCurrency' => self::DEFAULT_CURRENCY_SIGN,
            'incomeCurrency' => $income_currency,
            'amountExchange' => Helper::numberFormat($amount_exchange),
            'paymentMethod' => $payment_method,
            'currentCurrency' => $current_currency,
            'exchangeTotal' => Helper::numberFormat($exchange_total),
            'paymentFee' => Helper::numberFormat($payment_fee),
            'exchangeFee' => Helper::numberFormat($exchange_fee),
            'exchangeWithoutFees' => Helper::numberFormat($exchange_without_fees)
        ];
    }

    public function getExchange(String $income_currency, Float $amount_exchange, String $payment_method) :Array
    {
        $params = 'json/last/'.$income_currency.'-'.self::DEFAULT_CURRENCY_SIGN;
        $response = $this->initialize($params);
        $result = $this->calculateFees($response, $amount_exchange, $payment_method);

        return $result;
    }

    public function getDefaultAvailable() : Array
    {
        $params = 'json/available';
        $response = $this->initialize($params);

        foreach ($response as $k => $v) {
            if (str_contains($k, '-'.self::DEFAULT_CURRENCY_SIGN)) {
                $available[$k] = $v;
            }
        }

        asort($available);

        foreach ($available as $k => $v) {
            $available[str_replace('-'.self::DEFAULT_CURRENCY_SIGN, '', $k)] = str_replace('/'.self::DEFAULT_CURRENCY_NAME, '', $v);
            unset($available[$k]);
        }

        return $available;
    }
}
