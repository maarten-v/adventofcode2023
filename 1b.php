<?php

/** @var string[] $input */
$input = file('input1.txt');
$total = 0;
foreach ($input as $line) {
    preg_match_all('/\d|one|two|three|four|five|six|seven|eight|nine/', $line, $matches);
    $total += (convertDigit($matches[0][0]) . convertDigit(end($matches[0])));
}

function convertDigit($match)
{
    switch ($match) {
        case 'one':
            return 1;
        case 'two':
            return 2;
        case 'three':
            return 3;
        case 'four':
            return 4;
        case 'five':
            return 5;
        case 'six':
            return 6;
        case 'seven':
            return 7;
        case 'eight':
            return 8;
        case 'nine':
            return 9;
        default:
            return $match;
    }
}
echo $total;