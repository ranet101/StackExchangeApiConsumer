<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Infrastructure\StackExchangeApi;

class AppTest extends TestCase
{
    /** 
     * @test 
     * 
     * App path must responds 400
     * */
    public function appResponds(): void
    {
        $response = $this->get('/');
        $response->assertStatus(400);
    }


    /** 
     * @test 
     * 
     * Api path must responds 404
     * */
    public function apiResponds(): void
    {
        $response = $this->get('/api');
        $response->assertStatus(404);
    }
    
    /** 
     * @test 
     * 
     * Check apiCall class and test with tag param
     * Expect 30 items & has_more = true
     * */
    public function stackExchangeApiTagCall(): void
    {
        $apiResponse    = StackExchangeApi::stackExchangeApiCall("javascript");
        $arrResult      = json_decode($apiResponse);
        $countOk        = (count($arrResult->items) === 30) ? true : false;
        $hasMore        = $arrResult->has_more;
        if($countOk && $hasMore)
            $this->assertTrue(true);
        else
            $this->assertTrue(false);
    }
    
    /** 
     * @test 
     * 
     * Check apiCall class and test with tag and fromDate params
     * Expect 30 items & has_more = true
     * */
    public function stackExchangeApiFromDateCall(): void
    {
        $apiResponse    = StackExchangeApi::stackExchangeApiCall("javascript","2023-01-01");
        $arrResult      = json_decode($apiResponse);
        $countOk        = (count($arrResult->items) === 30) ? true : false;
        $hasMore        = $arrResult->has_more;
        if($countOk && $hasMore)
            $this->assertTrue(true);
        else
            $this->assertTrue(false);
    }
    
    /** 
     * @test 
     * 
     * Check apiCall class and test with tag, fromDate amd toDate params
     * Expect 30 items & has_more = true
     * */
    public function stackExchangeApiToDateCall(): void
    {
        $apiResponse    = StackExchangeApi::stackExchangeApiCall("javascript","2023-01-01","2023-02-01");
        $arrResult      = json_decode($apiResponse);
        $countOk        = (count($arrResult->items) === 30) ? true : false;
        $hasMore        = $arrResult->has_more;
        if($countOk && $hasMore)
            $this->assertTrue(true);
        else
            $this->assertTrue(false);
    }
    
    /** 
     * @test 
     * 
     * Check apiCall class and test empty response
     * */
    public function stackExchangeApiEmptyResponse(): void
    {
        $apiResponse    = StackExchangeApi::stackExchangeApiCall("javascriptlskad89sad7kjsahd");
        $arrResult      = json_decode($apiResponse);
        $countOk        = (count($arrResult->items) === 0) ? true : false;
        $hasMore        = $arrResult->has_more;
        if($countOk && !$hasMore)
            $this->assertTrue(true);
        else
            $this->assertTrue(false);
    }

}
