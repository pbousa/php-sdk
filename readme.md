# PHP-SDK

[![Latest Stable Version](https://poser.pugx.org/pbousa/php-sdk/v/stable.svg)](https://packagist.org/packages/pbousa/php-sdk)
[![Total Downloads](https://poser.pugx.org/pbousa/php-sdk/downloads.svg)](https://packagist.org/packages/pbousa/php-sdk)
[![Latest Unstable Version](https://poser.pugx.org/pbousa/php-sdk/v/unstable.svg)](https://packagist.org/packages/pbousa/php-sdk)
[![License](https://poser.pugx.org/pbousa/php-sdk/license.svg)](https://packagist.org/packages/pbousa/php-sdk)

The **Photo Booth Options PHP SDK** helps developers leverage the [Photo Booth Options][pbousa] API to build
applications using PHP scripting language.

## Quickstart

### Get all users for a given machine

```php
<?php
// Following line not needed if using composer autoloader
require('/path/to/pbousa/php-sdk/src/PboApi/PboApi.php');

$token = 'AABBA';

$client = new \PboApi\Common\Client($token);

$users = $client->machines->get(array('machine_uuid' => 'uuid_of_machine'));

print_r($users);
```

### Getting and setting meta data

```php
// Get some meta data
$serialNumber = $machine->getMeta('serial_number');

// Get a meta data group
$cameraData = $machine->getMetas('hardware.camera');


// Update a single meta data entry
$meta = new \PboApi\Models\Meta('my.meta.key', 'this is some revealing information');
$machine->setMeta($meta);

// Update multiple meta data entries
$machine->setMetas([
    new \PboApi\Models\Meta('my.meta.key', 'this is some revealing information'),
    new \PboApi\Models\Meta('other.meta.key', 'I need this for later'),
]);

// You can also chain them like so...
$machine->setMeta('my.meta.key', 'this is some revealing information')
    ->setMeta('other.meta.key', 'I need this for later')
    ->setMeta('very.important.data', 'eat breakfast every day');

// Or combine both
$machine->setMeta('my.meta.key', 'this is some revealing information')
    ->setMetas([
        new \PboApi\Models\Meta('other.meta.key', 'I need this for later'),
    ]);
```


## Resources
* [Issues][sdk-issues] – Report issues and submit pull requests (see [Apache 2.0 License][sdk-license])

[sdk-issues]: https://github.com/pbousa/php-sdk/issues
[sdk-license]: http://www.apache.org/licenses/LICENSE-2.0

[pbousa]: http://www.pbousa.com/
