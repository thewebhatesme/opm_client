<?php

$loader = include_once __DIR__ . "/../vendor/autoload.php";
$loader->add("phmLabs", __DIR__ . "/../src/");
$loader->add("Doctrine", __DIR__ . "/../src/");
$loader->add("Whm", __DIR__ . "/../src/");
$loader->add("Whm\\Test", __DIR__ . "/tests/");