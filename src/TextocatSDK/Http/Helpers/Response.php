<?php

namespace TextocatSDK\Http\Helpers;

use TextocatSDK\Http\Exception as HttpException;

class Response {
  public static $errorMessages = [
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

  public $body;
  public $code;

  public function __construct($body, $header) {
    $this->body = $body;
    $this->codeFromHeader($header);

    if(isset(self::$errorMessages[$this->code])) {
      throw new HttpException(self::$errorMessages[$this->code], $this->code);
    }
  }

  private function codeFromHeader($header) {
    preg_match('/\s(\d+)\s/', $header[0], $matches);

    $this->code = $matches[1];
  }
}