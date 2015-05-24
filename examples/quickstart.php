<?php

require_once './inc.php';

use \TextocatSDK\Http\Client as KittyClient;

$result = (new KittyClient(API_KEY))->batch(\TextocatSDK\Document(
  'Председатель совета директоров ОАО «МДМ Банк» Олег Вьюгин — о том, чему
   приведет обмен санкциями между Россией и Западом в следующем году.
   Беседовала Светлана Сухова.'
))->syncQueue();

var_dump($result);