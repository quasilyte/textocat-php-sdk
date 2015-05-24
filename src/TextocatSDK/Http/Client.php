<?php

namespace TextocatSDK\Http;

use TextocatSDK\Textocat;
use Qweb\Request\JsonRequest;

class Client {
  private $apiKey;

  /*
   * Public:
   */

  public function __construct($apiKey) {
    Textocat::init();

    $this->apiKey = $apiKey;
  }

  public function batch($docs) {
    return new Batch(
      isset($docs['text']) ? [$docs] : $docs, $this->authJsonRequest()
    );
  }

  public function retrieveAll(array $batches) {
    return $this->authJsonRequest()
      ->getParamAdd(['batch_id' => array_map(function($batch) {
        return $batch->id();
      }, $batches)])
      ->sendJavish('retrieve', true);
  }

  public function syncRetrieveAll(array $batches, $delay = Textocat::DELAY) {
    $this->syncAll($batches, $delay);

    return $this->retrieveAll($batches);
  }

  public function syncAll(array $batches, $delay = Textocat::DELAY) {
    foreach($batches as $batch) {
      $batch->sync($delay);
    }
  }

  /*
   * Private:
   */

  private function authJsonRequest() {
    return (new JsonRequest(Textocat::resource('entity/')))
      ->getParamAdd(['auth_token' => $this->apiKey]);
  }
}