<?php
// https://stackoverflow.com/a/6633113/622843
// A few constants.

const DIRECTION_DOWN = 0;
const DIRECTION_RIGHT = 1;
const DIRECTION_UP = 2;
const DIRECTION_LEFT = 3;

function getSpiral($size)
{
    $spiral = [];
    // The initial number.
    $number = 1;
    // The initial direction.
    $direction = DIRECTION_RIGHT;
    // The distance and number of points remaining before switching direction.
    $remainingDistance = $sideDistance = 1;
    // The initial "x" and "y" point.
    $col = $row = (int)round($size / 2);
    $origin = [$col, $row];
    // The dimension of the spiral.
    $dimension = $size * $size;

    // Loop
    for ($count = 0; $count < $dimension; $count++) {
        // Add the current number to the "x" and "y" coordinates.
        $spiral[$row][$col] = $number;
        // Depending on the direction, set the "x" or "y" value.
        switch ($direction) {
            case DIRECTION_RIGHT:
                $col++;
                break;
            case DIRECTION_UP:
                $row++;
                break;
            case DIRECTION_LEFT:
                $col--;
                break;
            case DIRECTION_DOWN:
                $row--;
                break;
        }
        // If the distance remaining is "0", switch direction.
        if (--$remainingDistance === 0) {
            if ($direction === DIRECTION_DOWN) {
                $direction = DIRECTION_LEFT;
                $sideDistance++;
            } else {
                if ($direction === DIRECTION_UP) {
                    $sideDistance++;
                }
                $direction--;
            }
            // Reset the distance remaining.
            $remainingDistance = $sideDistance;
        }
        $number++;
    }
    // Sort by "x" numerically, hashmap is in wrong order because it wasn't filled in incrementing index
    ksort($spiral, SORT_NUMERIC);
    foreach ($spiral as &$col) {
        ksort($col, SORT_NUMERIC);
    }
    return [
        $spiral,
        $origin,
    ];
}

/**
 * @param int $number
 * @param array[] $spiral
 * @return array
 */
function getCoordinates(int $number, array $spiral): array
{
    foreach ($spiral as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            if ($number === $value) {
                return [$rowIndex, $colIndex];
            }
        }
    }
    throw new InvalidArgumentException('Number not in spiral');
}

/**
 * @param array $vector1
 * @param array $vector2
 * @return int
 */
function distance(array $vector1, array $vector2): int
{
    $n = count($vector1);
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        $sum += abs($vector1[$i] - $vector2[$i]);
    }
    return $sum;
}

/**
 * @param int $size
 * @param array $spiral
 */
function printSpiral(int $size, array $spiral)
{
    foreach ($spiral as $row) {
        foreach ($row as $col) {
            echo str_pad($col, strlen($size * $size), ' ', STR_PAD_LEFT) . ' ';
        }
        echo "\n";
    }
    echo "\n";
}

$input = (int)trim(file_get_contents(__DIR__ . '/input'));
$size = (int)ceil(sqrt($input));

/** @var array[] $spiral */
list($spiral, $origin) = getSpiral($size);

$coordinates = getCoordinates($input, $spiral);
echo distance($origin, $coordinates);