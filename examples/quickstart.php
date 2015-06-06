<?php

// Say you already installed `textocat-php-sdk' via `composer'
// then next line is sufficient to have all classes ready to be loaded.
require "./vendor/autoload.php";

use \TextocatSDK\Http\Client as KittyClient;
use \TextocatSDK\Textocat as Kitty;

// Shortest way possible:
$result = (new KittyClient('--API KEY--'))->batch(Kitty::Document(
  'Председатель совета директоров ОАО «МДМ Банк» Олег Вьюгин — о том, чему
   приведет обмен санкциями между Россией и Западом в следующем году.
   Беседовала Светлана Сухова.'
))->syncRetrieve();

// * Create client instance; it must know your `auth_token'
// * Instantiate a batch from client with single document (50 is max)
// * Launch blocking `retrieve' method to receive results

var_dump($result);