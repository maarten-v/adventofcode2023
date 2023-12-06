<?php

/** @var string[] $input */
$input = file('input2.txt');
$total = 0;

$max['red'] = 12;
$max['green'] = 13;
$max['blue'] = 14;

foreach ($input as $line) {
    $impossible = false;
    $game = (int) substr(explode(' ', $line)[1], 0, -1);
    $draws = explode(';', explode(':', $line)[1]);
    foreach ($draws as $draw) {
        $amounts = explode(',', $draw);
        foreach ($amounts as $amount) {
            [$number, $color] = explode(' ', trim($amount));
            if ($number > $max[$color]) {
                $impossible = true;
            }
        }
    }
    if (!$impossible) {
        $total += $game;
    }
}

echo $total;