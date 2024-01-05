<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$startTime = microtime(true);

/** @var string[] $input */
$input = file('input8.txt');
$instructions = trim($input[0]);

$counter = 0;
$map = [];
foreach ($input as $line) {
    $counter++;
    if ($counter < 3) {
        continue;
    }
    $directions = explode(' = ', trim($line));
    $target = explode(', ', $directions[1]);
    $map[$directions[0]]['L'] = substr($target[0], 1);
    $map[$directions[0]]['R'] = substr($target[1], 0, -1);
}

$instructions = str_split($instructions);
$currentPositions = array_filter(array_keys($map), static function ($key) {
    return str_ends_with($key, 'A');
});

$multiples = [];
foreach ($currentPositions as $currentPosition) {
    $counter = 0;
    while (!str_ends_with($currentPosition, 'Z')) {
        foreach ($instructions as $instruction) {
            $counter++;
            $currentPosition = $map[$currentPosition][$instruction];
        }
    }
    $multiples[] = $counter;
}

echo lcm_array($multiples) . PHP_EOL;

function gcd($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
}

function lcm($a, $b): float|int
{
    return ($a / gcd($a, $b)) * $b;
}

function lcm_array($numbers): float|int
{
    $lcm = 1;
    foreach ($numbers as $number) {
        $lcm = lcm($lcm, $number);
    }
    return $lcm;
}

$endTime = microtime(true);
$duration = $endTime - $startTime;
echo "Execution time: " . $duration . " seconds";