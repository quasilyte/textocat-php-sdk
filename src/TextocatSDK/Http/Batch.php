<?php

namespace TextocatSDK\Http;

class Batch {
  private $rq;
  private $docs;

  private $id;
  private $status;

  /*
   * Public:
   */

  public function __construct(array $docs, $request) {
    $this->docs = $docs;
    $this->rq = $request;
  }

  public function id() {
    return $this->id;
  }

  public function queue() {
    $resp = $this->rq()->postParamsSet($this->docs)->send('queue');

    $this->id = $resp['batchId'];
    $this->status = $resp['status'];

    return $this;
  }

  public function syncQueue($delay = 250000) {
    $this->queue();
    $this->sync($delay);

    return $this->isFinished() ? $this->retrieve() : false;
  }

  public function sync($delay) {
    do {
      usleep($delay);
      $this->request();
    } while($this->isInProgress());

    return $this;
  }

  public function request() {
    $resp = $this->rq()->getParamAdd($this->idParam())->send('request');

    $this->status = $resp['status'];

    return $this->isFinished();
  }

  public function retrieve() {
    $this->status = '';

    return $this->rq()->getParamAdd($this->idParam())->send('retrieve')['documents'];
  }

  public function update(array $response) {
    $this->id = $response['batchId'];
    $this->status = $response['status'];
  }

  public function isInProgress() {
    return $this->status == 'IN_PROGRESS';
  }

  public function isFinished() {
    return $this->status == 'FINISHED';
  }

  public function isFailed() {
    return $this->status == 'FAILED';
  }

  /*
   * Private:
   */

  private function rq() {
    return clone $this->rq;
  }

  private function idParam() {
    return ['batch_id' => $this->id];
  }
}