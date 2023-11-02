<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckParamDates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dateFields = ["fromDate","toDate"];
        foreach($dateFields as $dateField)
            if($request->$dateField)
                if(!$this->checkDateFormat($request->$dateField, "Y-m-d"))
                    return response()->json(["error"=>true,"errorCode"=>1,"msg"=>"$dateField parameter is not valid: " . $request->$dateField]);
        if($request->fromDate && $request->toDate)
            if(!$this->checkDiffDates($request->fromDate, $request->toDate))
                return response()->json(["error"=>true,"errorCode"=>1,"msg"=>"dateFrom cannot be greater than dateTo"]);
        return $next($request);
    }

    /**
     * Check if date is in correct format.
     * 
     * @param Date $date        Required. Date to check.
     * @param String $format    Required. Date format to be compared. Default Y-m-d.
     *
     * @return Boolean
     */
    protected function checkDateFormat($date, $format="Y-m-d")
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * false if date1 is bigger tha date2.
     * 
     * @param Date $date1   Required. Date to check.
     * @param Date $date2   Required. Date to check.
     *
     * @return Boolean
     */
    protected function checkDiffDates($date1, $date2)
    {
        if($date1 > $date2)
            return false;
        return true;
    }


}
