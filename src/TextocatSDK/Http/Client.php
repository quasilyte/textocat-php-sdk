<?php

namespace TextocatSDK\Http;

use TextocatSDK\Textocat;
use \TextocatSDK\Http\Helpers\JsonRequest;

class Client {
  private $apiKey;

  /*
   * Public:
   */

  public function __construct($apiKey) {
    $this->apiKey = $apiKey;
  }

  public function batch($docs) {
    return new Batch(
      isset($docs['text']) ? [$docs] : $docs, $this->authJsonRequest()
    );
  }

  public function retrieve(array $batches) {
    return $this->authJsonRequest()
      ->getParamAdd(['batch_id' => array_map(function($batch) {
        return $batch->id();
      }, $batches)])
      ->sendJavish('retrieve', true);
  }

  public function authJsonRequest() {
    return (new JsonRequest(Textocat::resource('entity/')))
      ->getParamAdd(['auth_token' => $this->apiKey]);
  }
}