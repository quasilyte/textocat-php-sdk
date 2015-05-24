<?php

namespace TextocatSDK\Http\Helpers;

class Request {
  protected $url;
  protected $header = [];

  protected $getParams = [];
  protected $postParams = [];

  protected $dataEncFn = 'http_build_query';

  public function __construct($url) {
    $this->url = $url;
  }

  public function headerLineAdd($line) {
    $this->header[] = $line;

    return $this;
  }

  public function getParamAdd(array $param) {
    $this->getParams[key($param)] = current($param);

    return $this;
  }

  public function getParamsSet($params) {
    $this->getParams = $params;

    return $this;
  }

  public function postParamAdd($param) {
    $this->postParams[] = $param;

    return $this;
  }

  public function postParamsSet($params) {
    $this->postParams = $params;

    return $this;
  }

  public function send($extraPath = '', $javishArrays = false) {
    $url = $this->urlWithParams($extraPath);

    return file_get_contents(
      $javishArrays ? preg_replace('/%5B[0-9]+%5D=/', '=', $url) : $url,
      false,
      $this->streamCtx()
    );
  }

  public function sendJavish($extraPath = '') {
    return $this->send($extraPath, true);
  }

  public function urlWithParams($extraPath = '') {
    return $this->url . $extraPath . '?' . http_build_query($this->getParams);
  }

  protected function streamCtx() {
    return stream_context_create([
      'http' => [
        'method' => $this->postParams === [] ? 'GET' : 'POST',
        'header' => $this->header,
        'content' => call_user_func($this->dataEncFn, $this->postParams)
      ]
    ]);
  }
}