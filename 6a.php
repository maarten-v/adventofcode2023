<?php

require_once __DIR__ . '/vendor/autoload.php';

$startTime = microtime(true);

/** @var string[] $input */
$input = file('input6.txt');
$times = array_filter(explode(' ', trim($input[0])));
array_shift($times);
$distances = array_filter(explode(' ', trim($input[1])));
array_shift($distances);

$timesBetter = [];
foreach ($times as $key => $time) {
    $timesBetter[$key] = 0;
    for ($i = 1; $i < $time; $i++) {
        $timeMoving = $time - $i;
        $distance = ($timeMoving * $i);
        if ($distance > $distances[$key]) {
            $timesBetter[$key]++;
        }
    }
}
echo array_product($timesBetter);