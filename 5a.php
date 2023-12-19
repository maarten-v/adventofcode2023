<?php

/** @var string[] $input */
$input = file('input5.txt');
$maps = [];
$mapCounter = 0;
foreach ($input as $line) {
    $line = trim($line);
    if (!isset($seeds)) {
        $numbers = explode(': ', $line)[1];
        $seeds = explode(' ', $numbers);
        continue;
    }
    if ($line === '') {
        continue;
    }
    if (str_ends_with($line, ':')) {
        $mapCounter++;
        continue;
    }
    $values = explode(' ', $line);
    $maps[$mapCounter][] = [
        'destination' => $values[0],
        'source' => $values[1],
        'range' => $values[2],
    ];
}

$results = [];
foreach ($seeds as $seed) {
    $result = $seed;
    foreach ($maps as $map) {
        $foundInMap = false;
        foreach ($map as $range) {
            if ($result <= ($range['source'] + $range['range']) && $result >= $range['source']) {
                $result = $range['destination'] + ($result - $range['source']);
                $foundInMap = true;
                break;
            }
        }
    }
    $results[] = $result;
}

echo min($results);
