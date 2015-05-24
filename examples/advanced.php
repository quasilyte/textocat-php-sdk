<?php

require_once './inc.php';

use \TextocatSDK\Http\Client as KittyClient;

$doc1 = \TextocatSDK\Document('Сурки, в атаку!');

$client = new KittyClient(API_KEY);

// Документ с тегом:
$doc2 = \TextocatSDK\Document('
  Председатель совета директоров ОАО «МДМ Банк»
  Олег Вьюгин — о том, чему приведет обмен санкциями между Россией и Западом
  в следующем году. Беседовала Светлана Сухова.
', '@important');

$batch = $client->batch([$doc1, $doc2]);

// Обёртка для блокирующего получения ответа:
$syncRes1 = $batch->syncRetrieve();
// Или:
$batch->queue();
$batch->sync(50000);
$syncRes2 = $batch->retrieve();

// Ручное управление:
$batch->queue();
sleep(1);
if($batch->request()) {
  $delayedRes1 = $batch->retrieve();
} else {
  $delayedRes1 = 'not finished yet...';
}
// Или:
$batch->queue();
do {
  usleep(50000);
  // Обновляем статус пакета документов.
  $batch->request();
} while($batch->isInProgress());
$delayedRes2 = $batch->retrieve();

// Можно запрашивать результаты с нескольких Batch за один раз.
// Подготовим второй Batch и завершённых коллекций станет две.
$batch2 = $client->batch(
  \TextocatSDK\Document('Yet another perl hacker')
)->queue(); // ->sync(50000); Мы можем производить синхронизацию здесь или...

// Забираем обе коллекции:
$both = $client->syncRetrieveAll([$batch, $batch2]); // ...здесь.
// Если бы мы вызвали ->sync(50000), тогда вместо syncRetrieveAll
// стоило бы воспользоваться ->retrieveAll([$batch, $batch2])

var_dump($both);