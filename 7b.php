<?php

declare(strict_types=1);

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
        if ($letter === 'J') {
            continue;
        }
        if (!isset($lettersArray[(string) $letter])) {
            $lettersArray[(string) $letter] = 0;
        }
        $lettersArray[(string) $letter]++;
    }
    arsort($lettersArray);
    $amounts = implode('', $lettersArray);
    $hands[$key]['rank'] = match($amounts) {
        // no jokers
        '5' => 1,
        '41' => 2,
        '32' => 3,
        '311' => 4,
        '221' => 5,
        '2111' => 6,
        '11111' => 7,

        // 1 joker
        '4' => 1,
        '31' => 2,
        '22' => 3,
        '211' => 4,
        '1111' => 6,

        // 2 jokers
        '3' => 1,
        '21' => 2,
        '111' => 4,

        // 3 jokers
        '2' => 1,
        '11' => 2,

        // 4 jokers
        '1' => 1,

        // 5 jokers
        '' => 1,
    };
}
usort($hands, static function ($a, $b) {
    if ($a['rank'] > $b['rank']) {
        return -1;
    }
    if ($a['rank'] < $b['rank']) {
        return 1;
    }
    $cardsA = str_split($a['cards']);
    $cardsB = str_split($b['cards']);
    for ($i = 0; $i < 5; $i++) {
        if (convertToInt($cardsA[$i]) > convertToInt($cardsB[$i])) {
            return 1;
        }
        if (convertToInt($cardsA[$i]) < convertToInt($cardsB[$i])) {
            return -1;
        }
    }
});
$totalScore = 0;
$counter = 1;
foreach ($hands as $hand) {
    $totalScore+= $hand['bid'] * $counter;
    $counter++;
}

echo $totalScore . PHP_EOL;

function convertToInt($card): int
{
    return match($card) {
        'A' => 14,
        'K' => 13,
        'Q' => 12,
        'J' => 1,
        'T' => 10,
        default => (int) $card,
    };
}

$endTime = microtime(true);
$duration = $endTime - $startTime;
echo "Execution time: " . $duration . " seconds";