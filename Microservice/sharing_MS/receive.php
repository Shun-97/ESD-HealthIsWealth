<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('linkedin_shared', 'topic', true, true, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$binding_key = "#.shared";
// if (empty($binding_keys)) {
//     file_put_contents('php://stderr', "Usage: $argv[0] $binding_key\n");
//     exit(1);
// }

// foreach ($binding_keys as $binding_key) {
//     $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
// }
$channel->queue_bind($queue_name, 'linkedin_shared', $binding_key);

echo " [*] Waiting for logs. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>