<?php

require_once __DIR__ . '/vendor/autoload.php';

$startTime = microtime(true);

/** @var string[] $input */
$input = file('input7.txt');
$hands = [];
$bids = [];
$ranks = [];
foreach ($input as $line) {
    [$cards, $bid] = explode(' ', trim($line));
    $hands[] = ['cards' => $cards, 'bid' => $bid];
};
$handsAmounts = [];
foreach ($hands as $key => $hand) {
    $letters = str_split($hand['cards']);
    $firstLetter = $letters[0];
    $fiveOfAKind = true;
    $lettersArray = [];
    foreach ($letters as $letter) {
       if (!isset($lettersArray[(string) $letter])) {
           $lettersArray[(string) $letter] = 0;
       }
       $lettersArray[(string) $letter]++;
    }
    arsort($lettersArray);
    $amounts = implode('', $lettersArray);
    $hands[$key]['rank'] = match($amounts) {
        '5' => 5,
        '41' => 4,
        '32' => 3,
        '311' => 4,
        '221' => 5,
        '2111' => 6,
        '11111' => 7,
    };
}

usort($hands, static function ($a, $b) {
    if ($a['rank'] > $b['rank']) {
        return 1;
    }
    if ($a['rank'] < $b['rank']) {
        return -1;
    }

});
ray($hands);
$endTime = microtime(true);
$duration = $endTime - $startTime;
echo "Execution time: " . $duration . " seconds";