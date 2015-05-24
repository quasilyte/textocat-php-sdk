<?php

require_once './inc.php';

use \TextocatSDK\Http\Service as KittyService;

$result = KittyService::status();

var_dump($result);
var_dump(KittyService::isOnline());
var_dump(KittyService::isOffline());
