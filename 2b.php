<?php

/** @var string[] $input */
$input = file('input2.txt');
$total = 0;

foreach ($input as $line) {
    $mins = [];
    $impossible = false;
    $game = (int) substr(explode(' ', $line)[1], 0, -1);
    $draws = explode(';', explode(':', $line)[1]);
    foreach ($draws as $draw) {
        $amounts = explode(',', $draw);
        foreach ($amounts as $amount) {
            [$number, $color] = explode(' ', trim($amount));
            if ($mins[$color] < $number) {
                $mins[$color] = $number;
            }
        }
    }
    $total += array_product($mins);
}

echo $total;