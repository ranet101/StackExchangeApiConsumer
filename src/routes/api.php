<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController as ApiController;
use App\Http\Middleware\CheckParamTag as CheckParamTag;
use App\Http\Middleware\CheckParamDates as CheckParamDates;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/get/{tag?}/{fromDate?}/{toDate?}',[ApiController::class, 'get'])->middleware([CheckParamTag::class]);
