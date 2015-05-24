# Unofficial Textocat PHP SDK

This is unofficial PHP sdk for [Textocat](http://textocat.com).

[Textocat API](http://docs.textocat.com/).

# Dependencies

No serious dependencies, but wrappers need some pretty ways to make<br>
HTTP requests, so tiny Qweb\Request lies in.

# Installation

@TODO: add package to pear or composer.

# Usage

```php
use \TextocatSDK\Http\Client as KittyClient;

$result = (new KittyClient(API_KEY))->batch(\TextocatSDK\Document(
  'Председатель совета директоров ОАО «МДМ Банк» Олег Вьюгин — о том, чему
   приведет обмен санкциями между Россией и Западом в следующем году.
   Беседовала Светлана Сухова.'
))->syncRetrieve();

var_dump($result);
```

Overall, to manipulate single Batch, use its methods;<br>
when it is time to collect multiple batches, use Client methods.<br>
<br>
There ary sync and non-locking types of methods.<br>
Sync methods just execute an request, checking while it is<br>
ready and only when return the control among with result.<br>

Above code snippet + one advanced script can be found at: [examples](./examples)
<br>
**Bonus!**
```php
$client = \TextocatSDK\Http\Client(API_KEY);

$doc1 = \TextocatSDK\Document(file_get_contents('some input file1'));
$doc2 = \TextocatSDK\Document(file_get_contents('some input file2'));

// It is better to always pass an array, but when there is only one
// document in a batch, we want a syntactic sugar.
$batch1 = $client->batch($doc1)->queue()->sync();
$batch2 = $client->batch([$doc2])->queue()->sync();

var_dump($client->retrieveAll([$batch1, $batch2]);
```

### TODO/ADD
  `tests`
  `package`