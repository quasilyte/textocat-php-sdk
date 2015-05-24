<?php

namespace TextocatSDK;

class Textocat {
  const SERVICE_URL = 'http://api.textocat.com/';
  const DELAY = 100000;

  public static function resource($resource) {
    return self::SERVICE_URL . $resource;
  }
}