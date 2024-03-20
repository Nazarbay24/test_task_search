<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Meilisearch\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

//    public function import()
//    {
//        $client = new Client('http://meilisearch:7700', 'aSampleMasterKey');
//
//        $airports_json = Storage::get('airports.json');
//        $airports = json_decode($airports_json, true);
//
//        foreach($airports as $key => &$airport) {
//            $airport['id'] = $key;
//        }
//
//        $airports_chunks = array_chunk($airports, 1000);
//
//        foreach ($airports_chunks as $chunk) {
//            $client->index('airports')->addDocuments($chunk);
//        }
//
//        return response()->json(['message' => 'Успешно импортировано']);
//    }

    public function search(Request $request)
    {
        $client = new Client('http://meilisearch:7700', 'aSampleMasterKey');
        $query = $request->input('query');

        $data = $client->index('airports')->search($query, ['limit' => 10])->getHits();

        return response()->json($data);
    }
}
