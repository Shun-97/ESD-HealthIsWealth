<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
  
try {
    $client = new Client(['base_uri' => 'https://www.linkedin.com']);
    $response = $client->request('POST', '/oauth/v2/accessToken', [
        'form_params' => [
                "grant_type" => "authorization_code",
                "code" => $_GET['code'],
                "redirect_uri" => REDIRECT_URL,
                "client_id" => CLIENT_ID,
                "client_secret" => CLIENT_SECRET,
        ],
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    $access_token = $data['access_token']; // store this token somewhere
    // echo $access_token;
    try {
        $client = new Client(['base_uri' => 'https://api.linkedin.com']);
        $response = $client->request('GET', '/v2/me', [
            'headers' => [
                "Authorization" => "Bearer " . $access_token,
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $linkedin_profile_id = $data['id'];
        // store this id somewhere
        $linkedin_id = $linkedin_profile_id;

        // echo $linkedin_id;
        $link = 'https://www.edamam.com/results/recipe/?recipe=goody-girl-championship-potatoes-ab4c6823e34da526e8b836af9e2d4392/?search=goody';
        $body = new \stdClass();
        $body->content = new \stdClass();
        $body->content->contentEntities[0] = new \stdClass();
        $body->text = new \stdClass();
        $body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
        $body->content->contentEntities[0]->entityLocation = $link;
        $body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "https://www.edamam.com/results/recipe/?recipe=goody-girl-championship-potatoes-ab4c6823e34da526e8b836af9e2d4392/?search=goody";
        $body->content->title = 'Wonderful website found!';
        $body->owner = 'urn:li:person:'.$linkedin_id;
        $body->text->text = 'I have found a great recipe on Health is Wealth! Please comment down below and I will share with you the recipes I have found that are beneficial to our health!';
        $body_json = json_encode($body, true);
        
        try {
            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
            $response = $client->request('POST', '/v2/shares', [
                'headers' => [
                    "Authorization" => "Bearer " . $access_token,
                    "Content-Type"  => "application/json",
                    "x-li-format"   => "json"
                ],
                'body' => $body_json,
            ]);
        
            if ($response->getStatusCode() !== 201) {
                echo 'Error: '. $response->getLastBody()->errors[0]->message;
            }
        
            echo 'Post is shared on LinkedIn successfully.';
        } catch(Exception $e) {
            echo $e->getMessage(). ' for link '. $link;
        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
} catch(Exception $e) {
    echo $e->getMessage();
}
?>