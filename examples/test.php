<?php

//Include autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Cherry\Templating\Templater;

define('LOGS_PATH', __DIR__ . '/var/cache');

$templateEngine = new Templater(__DIR__ . '/../examples/templates');

echo $templateEngine->render('index', [
    'name' => 'Temuri',
    'surname' => 'Takalandze'
]);
