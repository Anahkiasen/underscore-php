<?php
error_reporting(E_ALL);
/** @var $al \Composer\Autoload\ClassLoader */
$al = require_once __DIR__ . '/../vendor/autoload.php';
$al->add('fixtures', __DIR__);

require __DIR__ . '/_start.php';
