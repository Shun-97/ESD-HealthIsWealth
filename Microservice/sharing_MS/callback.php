<?php
session_start();
require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use GuzzleHttp\Client;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('linkedin_shared', 'topic', true, true, false);

$routing_key = 'linkedin.shared';

try {
    $msg = new AMQPMessage("---- Logging in to LinkedIn ----");

    $channel->basic_publish($msg, 'linkedin_shared', $routing_key, array('delivery_mode' => 2));
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

    $msg = new AMQPMessage("---- Successfully logged in and obtained access token ----");
    $channel->basic_publish($msg, 'linkedin_shared', $routing_key, array('delivery_mode' => 2));
    try {

        $msg = new AMQPMessage("---- Obtaining OAuth Code ----");
        $channel->basic_publish($msg, 'linkedin_shared', $routing_key);
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
        $link = 'https://www.edamam.com/results/recipe/?recipe=pitta-bread-01b1926ecd5a86fafc863ae15bdfeb1c/?search=bread';
        $body = new \stdClass();
        $body->content = new \stdClass();
        $body->content->contentEntities[0] = new \stdClass();
        $body->text = new \stdClass();
        $body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
        $body->content->contentEntities[0]->entityLocation = $link;
        $body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "https://www.edamam.com/results/recipe/?recipe=pitta-bread-01b1926ecd5a86fafc863ae15bdfeb1c/?search=bread";
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
                $msg = new AMQPMessage('!!!!!!! - Error: '. $response->getLastBody()->errors[0]->message, array('delivery_mode' => 2));
                $channel->basic_publish($msg, 'linkedin_shared', $routing_key);
            }
            $msg = new AMQPMessage("---- Successfully shared onto LinkedIn, redirecting back to upload.php ----");
            $channel->basic_publish($msg, 'linkedin_shared', $routing_key, array('delivery_mode' => 2));
            header("Location: ../../upload.php");
        } catch(Exception $e) {
            $msg = new AMQPMessage($e->getMessage(). ' for link '. $link);
            $channel->basic_publish($msg, 'linkedin_shared', $routing_key);
            $_SESSION['msg'] = "Error!";
            header("Location: ../../upload.php");
        }
    } catch(Exception $e) {
        $msg = new AMQPMessage($e->getMessage());
        $channel->basic_publish($msg, 'linkedin_shared', $routing_key);
        $_SESSION['msg'] = "Error!";
        header("Location: ../../upload.php");
    }
} catch(Exception $e) {
    $msg = new AMQPMessage($e->getMessage());
    $channel->basic_publish($msg, 'linkedin_shared', $routing_key);
    $_SESSION['msg'] = "Error!";
    header("Location: ../../upload.php");
}

$channel->close();
$connection->close();
?>