<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Misc\Helper;
use App\Models\Configuration;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ConfigurationController extends Controller
{
    /**
    * @OA\Post(
    *      path="/configuration",
    *      tags={"Configuration"},
    *      summary="Fees configuration",
    *      operationId="configuration",
    *      security={
    *          {"bearer": {}}
    *      },
    *      @OA\Parameter(
    *          name="boleto_fee",
    *          in="query",
    *          required=true,
    *          example="1.45",
    *          @OA\Schema(
    *              type="number"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="credit_card_fee",
    *          in="query",
    *          required=true,
    *          example="7.63",
    *          @OA\Schema(
    *              type="number"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="fee_amount_less",
    *          in="query",
    *          required=true,
    *          example="2",
    *          @OA\Schema(
    *              type="number"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="fee_amount_less_value",
    *          in="query",
    *          required=true,
    *          example="3000",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="fee_amount_greater",
    *          in="query",
    *          required=true,
    *          example="1",
    *          @OA\Schema(
    *              type="number"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="fee_amount_greater_value",
    *          in="query",
    *          required=true,
    *          example="3000",
    *          @OA\Schema(
    *              type="integer"
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
