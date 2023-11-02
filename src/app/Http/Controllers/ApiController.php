<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use App\Infrastructure\StackExchangeApi;
use App\Infrastructure\StackExchangeApiCache;

class ApiController extends Controller
{ 
    
    /**
     * Get endpoint. 
     * - Verifies tag param is not empty 
     * - Verifies dates params are valids.
     * - Call StackExchange Api and returns reuslts
     *
     * @param String $tag    Required. Tag to filter on.
     * @param Date $fromdate    Optional. Fromdate to filter on.
     * @param Date $todate      Optional. Todate to filter on.
     * 
     * @return Json
     */ 
    public function get(String $tag, $fromDate = false, $toDate = false)
    {
        if($cachedResults = StackExchangeApiCache::cacheExists($tag, $fromDate, $toDate)){
            return $this->modelResponse($cachedResults,"StackExchangeApiCache");
        }else{
            $apiResponse = StackExchangeApi::stackExchangeApiCall($tag, $fromDate, $toDate);
            StackExchangeApiCache::insert($apiResponse, $tag, $fromDate, $toDate);
            return $this->modelResponse($apiResponse,"StackExchangeApi");
        }
    }


    /**
     * Model local api response. 
     *
     * @param Array $results    Required. Array with results (api or cache).
     * @param String $from      Required. Data origin. If api or cache.
     * 
     * @return Json
     */ 
    private function modelResponse($results, $from)
    {
        $responseArray = [
            "dataOrigin"=>$from,
            "items"=>$results['items'],
            "has_more"=>$results['has_more']
        ];
        return $responseArray;
    }

}