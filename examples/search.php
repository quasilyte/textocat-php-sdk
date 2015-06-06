<?php

// Assumption: you included autoloader.

use \TextocatSDK\Http\Client as KittyClient;

$result = (new KittyClient(API_KEY))->search('Искандер');

var_dump($result);