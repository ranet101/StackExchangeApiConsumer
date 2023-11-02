<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Controller;

class ApiController extends Controller
{ 

    public function get(String $tag, $fromDate = false, $toDate = false)
    {
        return ["msg"=>"welcome"];
    }

}