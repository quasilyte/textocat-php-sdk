<?php

// Assumption: you included autoloader.

use \TextocatSDK\Http\Service as KittyService;

$result = KittyService::status();

var_dump($result);

var_dump(KittyService::isOnline());
var_dump(KittyService::isOffline());
