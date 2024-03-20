<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Meilisearch\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $client = new Client('http://meilisearch:7700', 'aSampleMasterKey');

    $airports_json = Storage::get('airports.json');
    $airports = json_decode($airports_json, true);

    foreach($airports as $key => &$airport) {
        $airport['id'] = $key;
    }

    $airports_chunks = array_chunk($airports, 1000);

    foreach ($airports_chunks as $chunk) {
        $client->index('airports')->addDocuments($chunk);
    }


    return view('search');
});
