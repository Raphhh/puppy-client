<?php

$args = $_GET;

$_SERVER = unserialize(base64_decode($args['server']));
$_GET = unserialize(base64_decode($args['get']));
$_POST = unserialize(base64_decode($args['post']));
$_COOKIE = unserialize(base64_decode($args['cookies']));
$_REQUEST = array_merge($_GET, $_POST, $_COOKIE); //todo gpc_order="GPC"
$_ENV = unserialize(base64_decode($args['env']));
foreach($_ENV as $key => $value){
    putenv("$key=$value");
}
//todo session
unset($args, $key, $value);

//var_dump($_SERVER, $_GET, $_POST, $_COOKIE, $_REQUEST);

require_once $_SERVER['SCRIPT_FILENAME'];