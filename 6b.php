<?php

require_once __DIR__ . '/vendor/autoload.php';

$startTime = microtime(true);

/** @var string[] $input */
$input = file('input6.txt');
$time = explode(':', str_replace(' ', '', trim($input[0])))[1];
$distanceToBeat = explode(':', str_replace(' ', '', trim($input[1])))[1];

$start = (1 + sqrt(1 - 4 * ($time * - $distanceToBeat))) / 2 * $time;
echo $start;



// wortelformule
// a = tijd
// b = -1
// c = - timetobeat