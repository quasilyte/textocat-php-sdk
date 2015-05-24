<?php

namespace TextocatSDK;

use Qweb\Request\Response;

class Textocat {
  const SERVICE_URL = 'http://api.textocat.com/';
  const DELAY = 100000;

  private static $initialized = false;

  /*
   * Public;
   */

  public static function resource($resource) {
    return self::SERVICE_URL . $resource;
  }

  public static function init() {
    if(!self::$initialized) {
      self::initQwebResponseHandlers();

      self::$initialized = true;
    }
  }

  /*
   * Private:
   */

  private static function initQwebResponseHandlers() {
    Response::$respCodeHandlers = [
      400 => 'Wrong format. Check response manually for information',
      401 => 'Auth token is invalid',
      402 => 'Month processing limit exceeded',
      403 => 'Not enought permissions',
      404 => 'Can not find batch by given id',
      405 => 'Wrong http-method',
      406 => 'Such input is unsupported',
      413 => 'Input data size limit exceeded',
      415 => 'Wrong mime-type. Check response manually for information',
      416 => 'Simultaneous collection request limit exceeded',
      429 => 'To many parallel connections',
      500 => 'Internal error',
      503 => 'Service unavailable'
    ];
  }
}