<?php

namespace Qweb\Request;

class Response {
  public static $respCodeHandlers = [];

  public $body;
  public $code;

  /*
   * Public:
   */

  public function __construct($body, $header) {
    $this->body = $body;
    $this->codeFromHeader($header);

    $this->checkoutResponseCode();
  }

  /*
   * Private:
   */

  private function checkoutResponseCode() {
    if(isset(self::$respCodeHandlers[$this->code])) {
      $handler = self::$respCodeHandlers[$this->code];

      if(is_callable($handler)) {
        $this->invokeCallback($handler);
        $handler($this->body);
      } else {
        throw new Exception($handler, $this->code);
      }
    }
  }

  private function invokeCallback(callable $handler) {
    $message = $handler($this->body);

    if(is_string($message)) {
      throw new Exception($message, $this->code);
    }
  }

  private function codeFromHeader($header) {
    preg_match('/\s(\d+)\s/', $header[0], $matches);

    $this->code = (int)$matches[1];
  }
}