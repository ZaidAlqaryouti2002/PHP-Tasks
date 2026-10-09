<?php

/* 1 */

function isPrime($number) {
    if ($number <= 1) {
        return false;
    }

    for ($i = 2; $i < $number; $i++) {
        if ($number % $i == 0) {
            return false;
        }
    }

    return true;
}

$input = 3;

if (isPrime($input)) {
    echo $input . " is a prime number" . "<br>";
} else {
    echo $input . " is not a prime number" . "<br>";
}

?>

<?php
  /* 2 */

  $input = "remove";
  echo strrev($input). "<br>";

?>

<?php
   /* 3 */

  function swap(&$x, &$y){
    $temp= $x;
    $x= $y;
    $y= $temp;
  }

  $x=12;
  $y=10;
  swap($x,$y);
  echo "y= ". $y. " x= ". $x . "<br>";

?>

<?php

 /* 4 */

function isArmstrong($number) {
    $sum = 0;
    $strNumber = (string)$number;
    $length = strlen($strNumber);

    for ($i = 0; $i < $length; $i++) {
        $digit = (int)$strNumber[$i];
        $sum += $digit ** 3; 
    }

    return $sum === $number;
}

$input = 407;

if (isArmstrong($input)) {
    echo $input . " is Armstrong Number";
} else {
    echo $input . " is not Armstrong Number";
}

?>

<?php

/*5*/

function isPalindrome($string) {
    // Remove non-alphanumeric characters
    $cleaned = preg_replace('/[^a-zA-Z0-9]/', '', $string);

    // Convert to lowercase
    $cleaned = strtolower($cleaned);

    // Compare with reversed string
    return $cleaned === strrev($cleaned);
}

$input = "Eva, can I see bees in a cave?";

if (isPalindrome($input)) {
    echo "Yes it is a palindrome";
} else {
    echo "No it is not a palindrome";
}

?>

<?php

/*6*/

function removeDuplicates($array) {
    // array_values resets the numeric keys back to 0, 1, 2...
    return array_values(array_unique($array));
}

$array1 = array(2, 4, 7, 4, 8, 4);

$array1 = removeDuplicates($array1);

print_r($array1);

?>

