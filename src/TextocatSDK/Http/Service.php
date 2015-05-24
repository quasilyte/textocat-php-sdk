<?php

namespace TextocatSDK\Http;

use TextocatSDK\Textocat;
use Qweb\Request\JsonRequest;

abstract class Service {
  const CODE_ONLINE = 200;
  const CODE_OFFLINE = 503;

  public static function status() {
    return (new JsonRequest(Textocat::resource('status')))->send();
  }

  public static function isOnline() {
    return (new JsonRequest(Textocat::resource('status')))
      ->send()['statusCode'] == self::CODE_ONLINE;
  }

  public static function isOffline() {
    return (new JsonRequest(Textocat::resource('status')))
      ->send()['statusCode'] == self::CODE_OFFLINE;
  }
}