# Unofficial Textocat PHP SDK

This is unofficial PHP sdk for [Textocat](http://textocat.com).<br>
It is lazily maintained and recommended as an example of usage,<br>
but not supposed to be used as an backbone for real app.<br>
<br>
License? BSD, I guess.

Link below contains a list of currently provided methods by Textocat:<br>
[Textocat API](http://docs.textocat.com/).

# Dependencies

No serious dependencies, but wrappers need some pretty ways to make<br>
HTTP requests, so tiny Qweb\Request lies in.<br>
In current implementation it is not a trivial task to change this<br>
library because code is hardly bound to it. Going to change that one day.

# Installation

Easy with Composer:<br>
`composer require 'quasilyte/textocat-php-sdk:dev-master'`

# Usage

```php
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
```

Overall, to manipulate single Batch, use its methods;<br>
when it is time to collect multiple batches, use Client methods.<br>
<br>
There ary sync and non-locking types of methods.<br>
Sync methods just execute an request, checking while it is<br>
ready and only when return the control among with result.<br>

Above code snippet + one advanced script can be found at: [examples](./examples)
<hr>
```php
<?php

require "./vendor/autoload.php";

use \TextocatSDK\Http\Client;
use \TextocatSDK\Textocat;

$client = Client(API_KEY);

$doc1 = Textocat::document(file_get_contents('some input file1'));
$doc2 = Textocat::document(file_get_contents('some input file2'));

// It is better to always pass an array, but when there is only one
// document in a batch, we want a syntactic sugar (and you got it!):
$batch1 = $client->batch($doc1)->queue()->sync();
$batch2 = $client->batch([$doc2])->queue()->sync();

var_dump($client->retrieveAll([$batch1, $batch2]);
```

### Conformity with Textocat API 0.3

Methods:
  * `Entity`
    * `POST|queue` supported via Batch instance
    * `GET|request` supported via Batch instance
    * `GET|retrieve` supported via Client and Batch instances
    * `GET|search` supported via Client instance
  * `Service`
    * `GET|status` supported via Service static methods

<br>
`100%`
