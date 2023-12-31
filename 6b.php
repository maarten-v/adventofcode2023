<?php

require_once __DIR__ . '/vendor/autoload.php';

$startTime = microtime(true);

/** @var string[] $input */
$input = file('input6.txt');
$time = explode(':', str_replace(' ', '', trim($input[0])))[1];
$distanceToBeat = explode(':', str_replace(' ', '', trim($input[1])))[1];

$start = (-$time + sqrt($time**2 - 4 *  $distanceToBeat)) / -2;
$end = (-$time - sqrt($time**2 - 4 *  $distanceToBeat)) / -2;
$start = ceil($start);
$end = floor($end);
echo $end - $start + 1 . PHP_EOL;
$endTime = microtime(true);
$duration = $endTime - $startTime;
echo "Execution time: " . $duration . " seconds";


// wortelformule
// a = tijd
// b = -1
// c = - timetobeat