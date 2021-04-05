<?php
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
  
$link = 'YOUR_LINK_TO_SHARE';
$access_token = 'YOUR_ACCESS_TOKEN';
$linkedin_id = 'YOUR_LINKEDIN_ID';
$body = new \stdClass();
$body->content = new \stdClass();
$body->content->contentEntities[0] = new \stdClass();
$body->text = new \stdClass();
$body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
$body->content->contentEntities[0]->entityLocation = $link;
$body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "THUMBNAIL_URL_TO_POST";
$body->content->title = 'YOUR_POST_TITLE';
$body->owner = 'urn:li:person:'.$linkedin_id;
$body->text->text = 'YOUR_POST_SHORT_SUMMARY';
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