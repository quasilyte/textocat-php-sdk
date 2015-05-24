<?php

namespace TextocatSDK;

class Textocat {
  public static $serviceUrl = 'http://api.textocat.com/';

  public static function resource($resource) {
    return self::$serviceUrl . $resource;
  }
}