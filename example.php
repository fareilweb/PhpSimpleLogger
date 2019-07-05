<?php
require(__DIR__ . '/src/PhpSimpleLogger.php');

$logger = new PhpSimpleLogger(__DIR__ . '/example_logs/', 'mylog.log', true, true);

$logger->info("Page was visited");
