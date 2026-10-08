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

  function swap(&$x, &$y){
    $temp= $x;
    $x= $y;
    $y= $temp;
  }

  $x=12;
  $y=10;
  swap($x,$y);
  echo "y= ". $y. " x= ". $x;

?>

<?php

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