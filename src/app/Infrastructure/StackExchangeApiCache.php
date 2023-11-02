<?php
namespace App\Infrastructure;

use App\Models\StackExchangeApiResponses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StackExchangeApiCache
{

    /**
     * Checks if exists in cache database
     *
     * @param String $tag       Required. Tag to filter on.
     * @param Date $fromDate    Optional. fromDate to filter on.
     * @param Date $toDate      Optional. toDate to filter on.
     * 
     * @return Array
     */ 
    public static function cacheExists($tag, $fromDate = false, $toDate = false)
    {
        if($cachedResults = StackExchangeApiCache::search($tag, $fromDate, $toDate))
            return $cachedResults;
        return false;
    }

    public static function search($tag, $fromDate = false, $toDate = false)
    {
        $query = new StackExchangeApiResponses;
        $conditions = [["tag", $tag]];
        if($fromDate)
            array_push($conditions, ["from_date", "like", $fromDate."%"]);
        if($toDate)
            array_push($conditions, ["to_date", "like", $toDate."%"]);
        $query = $query->where($conditions);
        if(!$fromDate)
            $query->whereNull("from_date");
        if(!$toDate)
            $query->whereNull("to_date");
        $query = $query->get();
        if($query->isEmpty())
            return false;
        $queryArray = $query->toArray()[0];
        $queryArray['has_more'] = ($queryArray['has_more']) ? true : false;
        $queryArray['items'] = json_decode($queryArray['items']);
        return $queryArray;
    }

    public static function insert($apiResponse, $tag, $fromDate = false, $toDate = false)
    {
        $query = new StackExchangeApiResponses;
        $query->tag = $tag;
        $query->from_date = ($fromDate) ? $fromDate : NULL;
        $query->to_date = ($toDate) ? $toDate : NULL;
        $query->page = 1;
        $query->has_more = ($apiResponse['has_more']) ? 1 : 0;
        $query->items = json_encode($apiResponse['items']);
        $query->save();
    }
    
}