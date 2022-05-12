<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Misc\Helper;
use App\Models\Configuration;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ConfigurationController extends Controller
{
    public function store(ConfigurationRequest $request) :JsonResponse
    {
        $configuration = Configuration::first();

        $configuration->boleto_fee = Helper::percentageToFloat($request->input('boleto_fee'));
        $configuration->credit_card_fee = Helper::percentageToFloat($request->input('credit_card_fee'));
        $configuration->fee_amount_less = Helper::percentageToFloat($request->input('fee_amount_less'));
        $configuration->fee_amount_less_value = $request->input('fee_amount_less_value');
        $configuration->fee_amount_greater = Helper::percentageToFloat($request->input('fee_amount_greater'));
        $configuration->fee_amount_greater_value = $request->input('fee_amount_greater_value');

        $configuration->save();

        return response()->json([
            $configuration
        ], Response::HTTP_OK);
    }
}
