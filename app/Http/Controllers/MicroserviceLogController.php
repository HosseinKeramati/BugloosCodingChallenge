<?php

namespace App\Http\Controllers;

use App\Models\MicroserviceLog;
use Illuminate\Http\Request;
use Validator;

class MicroserviceLogController extends Controller
{

    /**
        * @OA\Get(
        * path="/api/logs/count",
        * operationId="getCount",
        * tags={"logs"},
        * summary="Logs count",
        * description="Get different microservices' logs count",
        *     @OA\Parameter(
        *      name="serviceNames",
        *      description="order-service, invoice-service, etc",
        *      in="query",
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="statusCode",
        *      in="query",
        *      @OA\Schema(
        *           type="integer"
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="startDate",
        *      description="YYYY-MM-DD",
        *      in="query",
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="endDate",
        *      description="YYYY-MM-DD",
        *      in="query",
        *      @OA\Schema(
        *           type="string"
        *      )
        *   ),
        *      @OA\Response(
        *          response=200,
        *          description= "Successful operation",
        *          
        *          @OA\JsonContent(
        *              type="object",
        *              @OA\Property(
        *                  format="string", 
        *                  default="45",
        *                  property="count"
        *              ),
        *          
        *          )
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Invalid inputs",
        *          @OA\JsonContent(
        *              type="object",
        *              @OA\Property(
        *                  format="string", 
        *                  default="Invalid input",
        *                  property="errorMessage"
        *              ),
        *              @OA\Property(
        *                  format="string", 
        *                  default="serviceNames, statusCode, startDate, endDate",
        *                  property="validInputs"
        *              ),
        *          
        *          )
        *          ),
        * )
        */
    public function count(Request $request)
    {

        $queryParameters = $request->all();

        $hasInvaliInput = MicroserviceLog::logsCountHasWrongFilterInput($queryParameters);

        if($hasInvaliInput){
            return response()->json([
                'status' => 'ok',
                'res' => [
                    'errorMessage' => 'Invalid input',
                    'validInputs' => 'serviceNames, statusCode, startDate, endDate',
                ],
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'statusCode' => 'integer',
            'startDate' => 'date',
            'endDate' => 'date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'res' => $validator->messages()->all(),
            ], 400);
        }


        $count = MicroserviceLog::logsCountWithFilters($queryParameters);

        return response()->json([
            "status" => "ok",
                'res' => [
                    'count' => $count,
                ],
            ], 200);
        
    }
}
