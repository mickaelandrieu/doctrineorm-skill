# DBAL & Doctrine integration in Jarvis micro framework

## Installation

you need to install it using composer and then be sure that this configuration 
is available when Jarvis Application is started:

```php
<?php
/* config.php */
const DOCTRINE_CONFIG = [
    'db' => [
        'dbname' => 'backbee',
        'user' => 'root',
        'password' => 'A1nges6!',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ],
    'orm' => [
        'debug' => false,
        'entity_path' => __DIR__.'/src/Entity'
    ]
];
```

For instance, you can create a ``config.php`` file at the root of your project and then
require or include it in your front controller.


```php
<?php

require_once('./vendor/autoload.php');
require_once('./config.php');

use Jarvis\Jarvis;
/* ... */

$response = $jarvis->analyze();

$response->send();
```