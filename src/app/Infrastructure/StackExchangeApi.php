<?php
namespace App\Infrastructure;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class StackExchangeApi
{
    
    /**
     * Http call to StackExchange api
     * - Prepares paremters to be sent
     * - Do call
     * - Return result
     *
     * @param String $tag       Required. Tag to filter on.
     * @param Date $fromDate    Optional. fromDate to filter on.
     * @param Date $toDate      Optional. toDate to filter on.
     * 
     * @return Json
     */ 
    public static function stackExchangeApiCall($tag, $fromDate=false, $toDate=false)
    {
        try {
            $parameters = StackExchangeApi::prepareData($tag, $fromDate, $toDate);
            $apiResponse = Http::get(env('STACKAPP_ENDPOINT'), $parameters);
            if($apiResponse->failed())
                return response()->json(["error"=>true,"errorCode"=>30,"msg"=>"StackexchangeApi error: " . $apiResponse->getStatusCode()]);
            return $apiResponse;
        } catch (Exception $e) {    
            return response()->json(["error"=>true,"errorCode"=>31,"msg"=>"local api error: " . $e->getMessage()]);
        }       
    }

    /**
     * Model params array to be sended in api call
     * StackExchange api don't accept empty date params
     *
     * @param String $tag       Required. Tag to filter on.
     * @param Date $fromDate    Optional. fromDate to filter on.
     * @param Date $toDate      Optional. toDate to filter on.
     * 
     * @return Array
     */ 
    public static function prepareData($tag, $fromDate=false, $toDate=false)
    {
        $params = [
            'tagged' => $tag,
            'site' => env('STACKAPP_SITE'),
        ];
        if($fromDate)
            $params['fromDate']=$fromDate;
        if($toDate)
            $params['toDate']=$toDate;
        return $params;
    }

}