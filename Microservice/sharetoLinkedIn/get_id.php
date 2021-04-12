<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
  
$access_token = 'YOUR_ACCESS_TOKEN';
try {
    $client = new Client(['base_uri' => 'https://api.linkedin.com']);
    $response = $client->request('GET', '/v2/me', [
        'headers' => [
            "Authorization" => "Bearer " . $access_token,
        ],
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    $linkedin_profile_id = $data['id']; // store this id somewhere
} catch(Exception $e) {
    echo $e->getMessage();
}