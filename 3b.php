<?php

/** @var string[] $input */
$input = file('input3.txt');
$total = 0;
$lineNumber = 0;
$numbers = [];
$gears = [];

foreach ($input as $line) {
    $number = '';
    $charCounter = 0;
    $numberCounter = 0;
    foreach (str_split(trim($line)) as $character) {
        if (is_numeric($character)) {
            $number .= $character;
            if ($charCounter === strlen(trim($line)) - 1) {
                $numbers = storeNumber($number, $numbers, $lineNumber, $numberCounter, $charCounter);
            }
        } else {
            if ($character === '*') {
                $gears[$lineNumber][] = $charCounter;
            }
            if ($number !== '') {
                $numbers = storeNumber($number, $numbers, $lineNumber, $numberCounter, $charCounter);
                $numberCounter++;
                $number = '';
            }
        }
        $charCounter++;
    }
    $lineNumber++;
}
foreach ($gears as $lineNumber => $line) {
    foreach ($line as $gear) {
        $foundNumbers = [];
        if (isset($numbers[$lineNumber - 1])) {
            foreach ($numbers[$lineNumber - 1] as $number) {
                if ($number['start'] <= ($gear + 1) && $number['end'] >= ($gear - 1)) {
                    $foundNumbers[] = $number['number'];
                }
            }
        }

        if (isset($numbers[$lineNumber + 1])) {
            foreach ($numbers[$lineNumber + 1] as $number) {
                if ($number['start'] <= ($gear + 1) && $number['end'] >= ($gear - 1)) {
                    $foundNumbers[] = $number['number'];
                }
            }
        }

        if (isset($numbers[$lineNumber])) {
            foreach ($numbers[$lineNumber] as $number) {
                if ($gear === ($number['start'] - 1) || $gear === ($number['end'] + 1)) {
                    $foundNumbers[] = $number['number'];
                }
            }
        }
        if (count($foundNumbers) >= 2) {
            $total += array_product($foundNumbers);
        }
    }
}

function storeNumber(string $number, array $numbers, int $lineNumber, int $numberCounter, int $charCounter): array
{
    $numbers[$lineNumber][$numberCounter]['number'] = (int) $number;
    $numbers[$lineNumber][$numberCounter]['start'] = $charCounter - strlen($number);
    $numbers[$lineNumber][$numberCounter]['end'] = $charCounter - 1;
    return $numbers;
}

echo $total;

