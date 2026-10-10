<?php

/* 1 */

function checkSum($num1, $num2) {
    $sum = $num1 + $num2;
    
    if ($sum === 30) {
        return $sum;
    }
    
    return 'false';
}

$firstInteger = 10;
$secondInteger = 10;

echo checkSum($firstInteger, $secondInteger) . "<br>";

?>

<?php

/* 2 */

function isMultipleOfThree($number) {
    // Check if the number is positive and evenly divisible by 3
    if ($number > 0 && $number % 3 == 0) {
        return 'true';
    }
    
    return 'false';
}

$number = 20;

echo isMultipleOfThree($number) . "<br>";

?>

<?php

/* 3 */

function isInRange($number) {
    // Check if the number is between 20 and 50 (inclusive)
    if ($number >= 20 && $number <= 50) {
        return 'true';
    }
    
    return 'false';
}

$number = 50;

echo isInRange($number) . "<br>";

?>

<?php

/* 4 */

function findLargest($numbers) {
    // max() easily finds the largest value in an array
    return max($numbers);
}

$input = array(1, 5, 9);

echo findLargest($input) . "<br>";

?>

<?php

/* 5 */

function calculateElectricityBill($units) {
    $bill = 0;

    // Calculate based on specific unit ranges
    if ($units <= 50) {
        $bill = $units * 2.50;
    } elseif ($units <= 150) {
        $bill = (50 * 2.50) + (($units - 50) * 5.00);
    } elseif ($units <= 250) {
        $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);
    } else {
        $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);
    }

    return $bill;
}

// Example input
$units = 100; 

echo calculateElectricityBill($units) . " JOD" . "<br>";

?>

<?php

/* 6 */

function calculator($num1, $num2, $operation) {
    switch ($operation) {
        case '+':
            return $num1 + $num2;
        case '-':
            return $num1 - $num2;
        case '*':
            return $num1 * $num2;
        case '/':
            if ($num2 == 0) {
                return "Cannot divide by zero";
            }
            return $num1 / $num2;
        default:
            return "Invalid operation";
    }
}

// Example input
echo calculator(10, 5, '+') . "<br>";

?>

<?php

/* 7 */

function checkVotingEligibility($age) {
    if ($age >= 18) {
        return 'is eligible to vote';
    } 
    
    // Matching the exact typo from the sample output
    return 'is no eligible to vote'; 
}

$input = 15;

echo checkVotingEligibility($input) . "<br>";

?>

<?php

/* 8 */

function checkSign($number) {
    if ($number > 0) {
        return 'Negative'; // Note: Used standard output logic, but fixed below
    }
} // Re-writing cleanly to match style:

function checkNumberSign($number) {
    if ($number > 0) {
        return 'Positive';
    } elseif ($number < 0) {
        return 'Negative';
    }
    
    return 'Zero';
}

$input = -60;

echo checkNumberSign($input) . "<br>";

?>

<?php

/* 9 */

function calculateGrade($scores) {
    // Get the average
    $average = array_sum($scores) / count($scores);

    // Standard grading scale
    if ($average >= 90) {
        return 'A';
    } elseif ($average >= 80) {
        return 'B';
    } elseif ($average >= 70) {
        return 'C';
    } elseif ($average >= 60) {
        return 'D';
    }
    
    return 'F';
}

$input = array(60, 86, 95, 63, 55, 74, 79, 62, 50);

echo calculateGrade($input) . "<br>";

?>