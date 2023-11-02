<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckParamDates
{
    use Utilities;
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
                    return response()->json(["error"=>true,"errorCode"=>21,"msg"=>"$dateField parameter is not valid: " . $request->$dateField]);
        if($request->fromDate && $request->toDate)
            if(!$this->checkDiffDates($request->fromDate, $request->toDate))
                return response()->json(["error"=>true,"errorCode"=>22,"msg"=>"dateFrom cannot be greater than dateTo"]);
        return $next($request);
    }

}
