<?php
/* 1 */
$year = 2013;

// A year is a leap year if it is divisible by 4, but not by 100, unless it is also divisible by 400
if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
    echo 'This year is a leap year';
} else {
    echo 'This year is not a leap year';
}
?>

<?php
/* 2 */
$temperature = 27;

if ($temperature < 20) {
    echo 'We are in winter';
} else {
    echo 'It is summertime!';
}
?>

<?php
/* 3 */
$firstInteger = 2;
$secondInteger = 2;

if ($firstInteger === $secondInteger) {
    $result = ($firstInteger + $secondInteger) * 3;
    echo "( $firstInteger + $secondInteger ) * 3 = $result";
} else {
    $result = $firstInteger + $secondInteger;
    echo $result;
}
?>

<?php
/* 4 */
$divisibleByFour = [];

for ($i = 200; $i <= 250; $i++) {
    if ($i % 4 === 0) {
        $divisibleByFour[] = $i;
    }
}

// Convert the array into a comma-separated string
echo implode(',', $divisibleByFour);
?>

<?php
/* 5 */
$min = 11;
$max = 20;

// Create an array containing all numbers between the min and max
$randomNumbers = range($min, $max);

// Randomize the order of the elements inside the array
shuffle($randomNumbers);

// Convert the shuffled array into a space-separated string
echo implode(' ', $randomNumbers);
?>