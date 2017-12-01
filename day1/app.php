<?php

function calculateCaptchaSum(string $input) {
    $numbers = str_split($input);
    // copy first number to the end
    $numbers[] = $numbers[0];

    $sum = 0;
    $last = null;
    foreach($numbers as $number) {
        if((int)$number === (int)$last) {
            $sum += (int)$number;
        }
        $last = (int)$number;
    }

    return $sum;
}


$tests = [
    '1122' => 3,
    '1111' => 4,
    '1234' => 0,
    '91212129' => 9
];

foreach($tests as $input => $expectedOutput) {
    assert(calculateCaptchaSum($input) === $expectedOutput);
}

echo calculateCaptchaSum(file_get_contents(__DIR__.'/input'));