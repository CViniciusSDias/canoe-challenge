<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

$_SERVER['RUNTIME_OPTIONS'] = [
    'host' => '0.0.0.0',
    'port' => 8000,
];
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
