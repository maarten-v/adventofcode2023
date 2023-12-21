<?php

require_once __DIR__ . '/vendor/autoload.php';

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
        'destinationStart' => $values[0],
        'destinationEnd' => $values[0] + $values[2] - 1,
        'sourceStart' => $values[1],
        'sourceEnd' => $values[1] + ($values[2] - 1),
        'difference' => $values[0] - $values[1],
    ];
}
$seedRanges['starts'] = [];
$seedRanges['ranges'] = [];
foreach ($seeds as $key => $seed) {
    if ($key % 2 === 0) {
        $seedRanges['starts'][] = $seed;
    } else {
        $seedRanges['ranges'][] = $seed;
    }
}

$inverseCategories = array_reverse($maps);
foreach ($inverseCategories as $key => $map) {
    usort($map, static function($a, $b) {
        return $a['destinationStart'] <=> $b['destinationStart'];
    });
    if ($map[0]['destinationStart'] > 0) {
        $startMap = [];
        $startMap['destinationStart'] = 0;
        $startMap['destinationEnd'] =  $map[0]['destinationStart'] - 1;
        $startMap['sourceStart'] = 0;
        $startMap['sourceEnd'] = $map[0]['destinationStart'] - 1;
        $startMap['difference'] = 0;
        array_unshift($map, $startMap);
    }
    $endMap = [];
    $endMap['destinationStart'] = end($map)['destinationEnd'] + 1;
    $endMap['destinationEnd'] =  PHP_INT_MAX;
    $endMap['sourceStart'] = end($map)['destinationEnd'] + 1;
    $endMap['sourceEnd'] = PHP_INT_MAX;
    $endMap['difference'] = 0;
    $map[] = $endMap;
    $inverseCategories[$key] = $map;
}

$counter = 0;
foreach ($inverseCategories as $category) {
    if ($counter === 0) {
        $wantedDestinations = [];
        $wantedDestinations[] = ['start' => 0, 'end' => PHP_INT_MAX, 'difference' => 0];
    }
    $splitWantedDestinations = [];
    $wantedSources = [];
    foreach ($wantedDestinations as $wantedDestination) {
        $nextDestinationStart = $wantedDestination['start'];
        splitRanges($nextDestinationStart, $wantedDestination, $category, $splitWantedDestinations, $wantedSources);
    }
    $wantedDestinations = $wantedSources;
    $counter++;
}

function splitRanges(&$nextDestinationStart, $wantedDestination, $category, &$splitWantedDestinations, &$wantedSources): void
{
    foreach ($category as $range) {
        if ($nextDestinationStart === PHP_INT_MAX) {
            return;
        }
        if ($nextDestinationStart >= $range['destinationStart'] && $nextDestinationStart <= $range['destinationEnd']) {
            if ($range['destinationEnd'] >= $wantedDestination['end']) {
                $splitWantedDestinations[] = ['start' => $nextDestinationStart, 'end' => $wantedDestination['end'], 'difference' => $range['difference']];
                $wantedSources[] = ['start' => $nextDestinationStart - $range['difference'], 'end' => $wantedDestination['end'] - $range['difference']];
                $nextDestinationStart = ($wantedDestination['end'] === PHP_INT_MAX ? PHP_INT_MAX : $wantedDestination['end'] + 1);
                return;
            }
            $splitWantedDestinations[] = ['start' => $nextDestinationStart, 'end' => $range['destinationEnd'], 'difference' => $range['difference']];
            $wantedSources[] = ['start' => $nextDestinationStart - $range['difference'], 'end' => $range['destinationEnd'] - $range['difference']];
            $nextDestinationStart = ($range['destinationEnd'] === PHP_INT_MAX ? $range['destinationEnd'] : $range['destinationEnd'] + 1);
            splitRanges($nextDestinationStart, $wantedDestination, $category, $splitWantedDestinations, $wantedSources);
            return;
        }
    }
}

foreach ($wantedSources as $wantedSource) {
    foreach ($seedRanges['starts'] as $key => $seedRangeStart) {
        if ($seedRangeStart <= $wantedSource['end'] && ($seedRanges['ranges'][$key] + $seedRangeStart) >= $wantedSource['start']) {
            $nearestSource = $wantedSource['start'];
            break 2;
        }
    }
}

echo 'nearest source: ' . $nearestSource . PHP_EOL;

foreach ($maps as $map) {
    foreach ($map as $range) {
        if ($nearestSource <= $range['sourceEnd'] && $nearestSource >= $range['sourceStart']) {
            $nearestSource += $range['difference'];
            break;
        }
    }
}

echo 'nearest dest: ' . $nearestSource;