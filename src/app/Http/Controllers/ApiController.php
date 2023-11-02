<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use App\Infrastructure\StackExchangeApi;

class ApiController extends Controller
{ 
    
    /**
     * Get endpoint. 
     * - Verifies tag param is not empty 
     * - Verifies dates params are valids.
     * - Call StackExchange Api and returns reuslts
     *
     * @param String $tag       Required. Tag to filter on.
     * @param Date $fromdate    Optional. Fromdate to filter on.
     * @param Date $todate      Optional. Todate to filter on.
     * 
     * @return Json
     */ 
    public function get(String $tag, $fromDate = false, $toDate = false)
    {
        $apiResponse = StackExchangeApi::stackExchangeApiCall($tag, $fromDate, $toDate);
        return json_decode($apiResponse);
    }

}