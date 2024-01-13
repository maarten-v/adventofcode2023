<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$startTime = microtime(true);

/** @var string[] $input */
$input = file('input9.txt');

foreach ($input as $history) {
    $numbers = explode(' ', trim($history));
    $length = count($numbers);
    for ($i = 0; $i < $length; $i++) {
        if (!isset($previous)) {
            $previous = $numbers[$i];
        }
        $
    }
}


$endTime = microtime(true);
$duration = $endTime - $startTime;
echo "Execution time: " . $duration . " seconds";