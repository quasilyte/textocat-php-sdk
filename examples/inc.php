<?php

function __autoload($class) {
  require_once '../src/' . str_replace('\\', '/', $class) . '.php';
}

require_once '../src/TextocatSDK/inc.php';

const API_KEY = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';