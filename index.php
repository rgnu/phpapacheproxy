<?php

require_once dirname(__FILE__).'/ProxyHandler.class.php';

$config = require_once dirname(__FILE__).'/config.inc.php';
$path   = $_SERVER['REQUEST_URI'];
$user   = $_SERVER['REMOTE_USER'];
$name   = dirname($_SERVER['SCRIPT_NAME']);
$config = $config[$name];
$proxy  = new ProxyHandler($config['from'].$path, $config['to'].$path);

$proxy->setClientHeader('X-Forwarded-For', $_SERVER['REMOTE_ADDR']);
$proxy->setClientHeader('X-Forwarded-Host', $_SERVER['SERVER_NAME']);
$proxy->setClientHeader('X-Forwarded-Server', $_SERVER['SERVER_ADDR']);

if (isset($user)) {
    $proxy->setClientHeader('X-Forwarded-User', $user);
}
$proxy->execute();

