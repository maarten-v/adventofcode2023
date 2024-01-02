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
$currentPosition = 'AAA';
$counter = 0;
while ($currentPosition !== 'ZZZ') {
    foreach ($instructions as $instruction) {
        $counter++;
        $currentPosition = $map[$currentPosition][$instruction];
    }
}
echo $counter . PHP_EOL;

$endTime = microtime(true);
$duration = $endTime - $startTime;
echo "Execution time: " . $duration . " seconds";