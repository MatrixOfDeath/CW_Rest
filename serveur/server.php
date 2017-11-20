<?php

require_once "core/RestServer.php";
require_once "service/data.php";

$server = new RestServer();
$server->loadService('data');

?>