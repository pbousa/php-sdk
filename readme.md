# PHP-SDK

[![Latest Stable Version](https://poser.pugx.org/pbo/php-sdk/v/stable.svg)](https://packagist.org/packages/pbousa/php-sdk)
[![Total Downloads](https://poser.pugx.org/pbo/php-sdk/downloads.svg)](https://packagist.org/packages/pbousa/php-sdk)
[![Latest Unstable Version](https://poser.pugx.org/pbo/php-sdk/v/unstable.svg)](https://packagist.org/packages/pbousa/php-sdk)
[![License](https://poser.pugx.org/pbo/php-sdk/license.svg)](https://packagist.org/packages/pbousa/php-sdk)

The **Photo Booth Options PHP SDK** helps developers leverage the [Photo Booth Options][pbousa] API to build
applications using PHP scripting language.

## Quickstart

### Get all users for a given machine

```php
<?php
// Following line not needed if using composer autoloader
require('/path/to/pbo/php-sdk/src/PboApi/PboApi.php');

$token = 'AABBA';

$client = new \PboApi\Common\Client($token);

$users = $client->machines->get(array('machine_uuid' => 'uuid_of_machine'));

print_r($users);
```


## Resources
* [Issues][sdk-issues] – Report issues and submit pull requests (see [Apache 2.0 License][sdk-license])

[sdk-issues]: https://github.com/pbousa/php-sdk/issues
[sdk-license]: http://www.apache.org/licenses/LICENSE-2.0

[pbousa]: http://www.pbousa.com/
