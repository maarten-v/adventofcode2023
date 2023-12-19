<?php

/** @var string[] $input */
$input = file('input4.txt');
$total = 0;
$copies = [];
$game = 0;
foreach ($input as $line) {
    $copies[$game] = $copies[$game] ?? 0;
    $copies[$game]++;
    $input = explode(':', $line)[1];
    $split = explode('|', $input);
    $winning = getNumbersFromString($split[0]);
    $numbers = getNumbersFromString($split[1]);
    $match = count(array_intersect($winning, $numbers));
    for ($i = $game + 1; $i <= $match + $game; $i++) {
        $copies[$i] = $copies[$i] ?? 0;
        $copies[$i] += $copies[$game];
    }
    $game++;
}

$copies = array_splice($copies, 0, $game);
echo array_sum($copies);

function getNumbersFromString($split): array
{
    return explode(' ', trim(str_replace('  ', ' ', $split)));
}