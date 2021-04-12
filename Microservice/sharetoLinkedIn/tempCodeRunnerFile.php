<?php
if (empty($binding_keys)) {
    file_put_contents('php://stderr', "Usage: $argv[0] $binding_key\n");
    exit(1);
}

foreach ($binding_keys as $binding_key) {
    $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
}