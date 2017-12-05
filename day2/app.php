<?php

function calculateRowChecksum(array $row)
{
    return max($row) - min($row);
}

function calculateChecksum(array $rows)
{
    return array_sum(array_map('calculateRowChecksum', $rows));
}


$testRows = [[5, 1, 9, 5], [7, 5, 3], [2, 4, 6, 8]];
$testAnswer = 18;

assert(calculateChecksum($testRows) === $testAnswer);


$input = file_get_contents(__DIR__ . '/input');
$lines = explode("\r\n", $input);
$inputRows = array_map(function($rowString) {
    return array_map('\intval', explode("\t", $rowString));
}, $lines);

echo calculateChecksum($inputRows);