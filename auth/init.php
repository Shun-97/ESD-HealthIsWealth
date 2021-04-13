<?php

use myPHPNotes\LinkedIn;

require_once "LinkedIn.php";

$app_id = "86707mg6xtcwjh";
$app_secret = "ccaAoT6K3vdLhhrk";
$callback = "http://127.0.0.1/esdproj/ESD-HealthIsWealth/sharing_MS/callback.php";
$scopes = "r_liteprofile";
$ssl = false; //TRUE FOR PRODUCTION ENV.

$linkedin = new LinkedIn($app_id, $app_secret, $callback, $scopes, $ssl);