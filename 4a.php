<?php

/** @var string[] $input */
$input = file('input4.txt');
$total = 0;
foreach ($input as $line) {
    $input = explode(':', $line)[1];
    $split = explode('|', $input);
    $winning = getNumbersFromString($split[0]);
    $numbers = getNumbersFromString($split[1]);
    $match = count(array_intersect($winning, $numbers));
    if ($match > 0) {
        $total += 2 ** ($match - 1);
    }
}
echo $total;

function getNumbersFromString($split): array
{
    return explode(' ', trim(str_replace('  ', ' ', $split)));
}