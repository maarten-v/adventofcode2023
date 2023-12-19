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
        'destinationStart' => $values[0],
        'destinationEnd' => $values[0] + $values[2] - 1,
        'sourceStart' => $values[1],
        'sourceEnd' => $values[1] + ($values[2] - 1),
        'range' => $values[2],
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

$inverseMaps = array_reverse($maps);
foreach ($inverseMaps as $key => $map) {
    usort($map, static function($a, $b) {
        return $a['destinationStart'] <=> $b['destinationStart'];
    });
    if ($map[0]['destinationStart'] > 0) {
        $startMap = [];
        $startMap['destinationStart'] = 0;
        $startMap['destinationEnd'] =  $map[0]['sourceStart'] - 1;
        $startMap['sourceStart'] = 0;
        $startMap['sourceEnd'] = $map[0]['sourceStart'] - 1;
        $startMap['range'] = $map[0]['sourceStart'] - 1;
        array_unshift($map, $startMap);
    }
    $inverseMaps[$key] = $map;
}

$counter = 0;
foreach ($inverseMaps as $map) {
    if ($counter === 0) {
        $smallestRangeStart = $map[0]['sourceStart'];
        $smallestRangeEnd = $map[0]['sourceEnd'];
        echo $smallestRangeStart . ' ' . $smallestRangeEnd;
    } else {
        foreach ($map as $range) {
            if ($range['destinationStart'] <= $smallestRangeStart) {
                var_dump($range);
                $smallestRangeStart = $range['destinationStart'];
                if ($smallestRangeEnd > $range['sourceEnd']) {
                    $smallestRangeEnd = $range['sourceEnd'];
                } else {
                    $smallestRangeEnd =
                }
                exit();
            }
        }
    }
    echo $counter . '  c' . PHP_EOL;
    $counter++;
}





//$nearest = PHP_INT_MAX;
//foreach ($seedRanges['starts'] as $key => $start) {
//    for ($i = $start; $i <= ($start + $seedRanges['ranges'][$key]); $i++) {
//        echo $i . ' ' . ($start + $seedRanges['ranges'][$key]) . PHP_EOL;
//        $result = $i;
//        foreach ($maps as $map) {
//            $foundInMap = false;
//            foreach ($map as $range) {
//                if ($result <= ($range['source'] + $range['range']) && $result >= $range['source']) {
//                    $result = $range['destination'] + ($result - $range['source']);
//                    $foundInMap = true;
//                    break;
//                }
//            }
//        }
//        if ($result < $nearest) {
//            $nearest = $result;
//        }
//    }
//}
//
//echo $nearest;
