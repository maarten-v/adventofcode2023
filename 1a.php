<?php

/** @var string[] $input */
$input = file('input1.txt');
$total = 0;
foreach ($input as $line) {
    preg_match_all('/\d/', $line, $matches);
    $total += ($matches[0][0] . end($matches[0]));
}
echo $total;