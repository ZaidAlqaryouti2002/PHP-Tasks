<?php
/* 1 */
$str = "Twinkle, twinkle, little star.";

var_dump (explode(" " , $str));
echo "<br>";
?>

<?php
/* 2 */
 $char = 'a';

 if ($char === 'z')
 echo 'a';
 

 else 
 echo ++$char;
 
?>

<?php
/* 3 */

$original = 'The brown fox';
$insert = 'quick ';
$position = 4; 

$result = substr_replace($original, $insert, $position, 0);

echo $result;
?>

<?php
/* 4 */

$string = 'The quick brown fox';

$firstWord = explode(' ', $string)[0];

echo $firstWord; 
?>

<?php
/* 5 */
// str_replace replaces all occurrences of '0' with an empty string
$original = '0000657022.24';
$result = str_replace('0', '', $original);

echo $result;
?>

<?php
/* 6 */
// rtrim removes specific characters from the right end of a string
$original = 'The quick brown fox jumps over the lazy dog---';
$result = rtrim($original, '-');

echo $result;
?>

<?php
/* 7 */
$original = 'The quick brown fox jumps over the lazy dog';

// Break the string into an array, slice the first 5 elements, and join them back
$words = explode(' ', $original);
$first_five = array_slice($words, 0, 5);
$result = implode(' ', $first_five);

echo $result;
?>

<?php
/* 8 */
// Similar to task 5, just replace the comma with an empty string
$original = '2,543.12';
$result = str_replace(',', '', $original);

echo $result;
?>