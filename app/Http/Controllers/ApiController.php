<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function github($username){

        $client = new GuzzleClient();
        $response = $client->get("https://api.github.com/users/$username");
$body = json_decode($response->getBody());
dd($body);
    }
}
