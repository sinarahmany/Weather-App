<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Zttp\Zttp;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('weather', function(){
    $apiKey = config('services.weatherapi.key');
    $lat = request('lat');
    $lng = request('lng');
    $response = zttp::get("https://api.weatherapi.com/v1/current.json?key=$apiKey&q=$lat,$lng&aqi=no");
    $response2 = zttp::get("https://api.weatherapi.com/v1/forecast.json?key=$apiKey&days=7&q=$lat,$lng&aqi=no");
   // return $response->json();
    return $response2->json();
});
