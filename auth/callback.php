<?php
require_once "init.php";

$accessToken = $linkedin->getAccessToken($_GET['code']);

$profileObject = $linkedin->getPerson();
$emailObject = $linkedin->getEmail();

var_dump($accessToken);
var_dump($profileObject);
var_dump($emailObject);
?>