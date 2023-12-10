<?php

/** @var string[] $input */
$input = file('input3.txt');
$total = 0;
$lineNumber = 0;
$numbers = [];
$symbols = [];

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
            if ($character !== '.') {
                $symbols[$lineNumber][] = $charCounter;
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
foreach ($numbers as $lineNumber => $line) {
    foreach ($line as $number) {
        if (isset($symbols[$lineNumber - 1])) {
            foreach ($symbols[$lineNumber - 1] as $symbol) {
                if ($number['start'] <= ($symbol + 1) && $number['end'] >= ($symbol - 1)) {
                    $total += $number['number'];
                    continue 2;
                }
            }
        }

        if (isset($symbols[$lineNumber + 1])) {
            foreach ($symbols[$lineNumber + 1] as $symbol) {
                if ($number['start'] <= ($symbol + 1) && $number['end'] >= ($symbol - 1)) {
                    $total += $number['number'];
                    continue 2;
                }
            }
        }

        if (isset($symbols[$lineNumber])) {
            foreach ($symbols[$lineNumber] as $symbol) {
                if ($symbol === ($number['start'] - 1) || $symbol === ($number['end'] + 1)) {
                    $total += $number['number'];
                    continue 2;
                }
            }
        }
    }
}

function storeNumber(string $number, array $numbers, int $lineNumber, int $numberCounter, mixed $charCounter): array
{
    $numbers[$lineNumber][$numberCounter]['number'] = (int)$number;
    $numbers[$lineNumber][$numberCounter]['start'] = $charCounter - strlen($number);
    $numbers[$lineNumber][$numberCounter]['end'] = $charCounter - 1;
    return $numbers;
}

echo $total;

