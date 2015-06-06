<?php

// Assumption: you included autoloader.

use \TextocatSDK\Http\Client as KittyClient;
use \TextocatSDK\Textocat as Kitty;

$client = new KittyClient(API_KEY);

$doc1 = Textocat::document('Сурки, в атаку!');

// Document with tag:
$doc2 = Textocat::document('
  Председатель совета директоров ОАО «МДМ Банк»
  Олег Вьюгин — о том, чему приведет обмен санкциями между Россией и Западом
  в следующем году. Беседовала Светлана Сухова.
', '@important');

// It is perfectly fine to declare document like that:
$doc3 = [
  'text' => 'Ещё одна конференция мёртвого языка программирования Perl.',
  'tag' => 'taggy-o'
];

$batch = $client->batch([$doc1, $doc2]);

// Send request and wait for result, then save it into `syncRes1':
$syncRes1 = $batch->syncRetrieve();
// Or:
$batch->queue();
$batch->sync(50000);
$syncRes2 = $batch->retrieve();

// Manually control everything:
$batch->queue();
sleep(1);
if($batch->request()) {
  $delayedRes1 = $batch->retrieve();
} else {
  $delayedRes1 = 'not finished yet...';
}
// Or:
$batch->queue();
do {
  usleep(50000);
  // Updating the collection status.
  $batch->request();
} while($batch->isInProgress());
$delayedRes2 = $batch->retrieve();

// It is possible to retrieve results from multiple batches.
// Let us prepare second batch.
$batch2 = $client->batch(
  \TextocatSDK\Document('Yet another perl hacker')
)->queue(); // ->sync(50000); Sync here...

// Fetch both collections:
$both = $client->syncRetrieveAll([$batch, $batch2]); // ...or here.
// If we call `sync(50000)', then instead of invoking `syncRetrieveAll'
// we would better use `retrieveAll' because of lower overhead.

var_dump($both);