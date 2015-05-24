# Unofficial Textocat PHP SDK

This is unofficial PHP sdk for [Textocat](http://textocat.com).

[Textocat API](http://docs.textocat.com/).

# Installation

@TODO: add package to pear.

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

[examples](./examples)

## TODO/ADD
  `exceptions`
  `tests`
  `pear`