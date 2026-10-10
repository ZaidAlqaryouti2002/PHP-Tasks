<?php
/*1*/
$inputlow= "zaid";
$upper= strtoupper($inputlow);
echo $upper. "<br>";

$inputup= "ZAID";
$lower= strtolower($inputup);
echo $lower. "<br>";

$firstl = ucfirst($inputlow);
echo $firstl. "<br>";

$words= "my name is zaid";
$wordsuc= ucwords($words);
echo $wordsuc. "<br>";
?>

<?php
/*2*/

$input= '085119';
$formattedTime = implode(':', str_split($input,2));

echo $formattedTime. "<br>";

?>

<?php

/* 3 */

$sentence = 'I am a full stack developer at orange coding academy';
$word = 'Orange';

// stripos performs a case-insensitive check to match 'Orange' with 'orange'
if (stripos($sentence, $word) !== false) {
    echo 'Word Found!' . "<br>";
} else {
    echo 'Word Not Found!' . "<br>";
}

?>

<?php

/* 4 */

$url = 'www.orange.com/index.php';

// basename extracts the trailing name component from a path/URL
$fileName = basename($url);

echo $fileName . "<br>";

?>

<?php

/* 5 */

$email = 'info@orange.com';

// strstr with true returns the part before the needle '@'
$userName = strstr($email, '@', true);

echo $userName . "<br>";

?>

<?php

/* 6 */

$email = 'info@orange.com';

// A negative offset retrieves characters starting from the end
$lastThreeChars = substr($email, -3);

echo $lastThreeChars . "<br>";

?>

<?php

/* 7 */

$chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';

// str_shuffle randomly rearranges characters without using rand()
$shuffled = str_shuffle($chars);

// Extract a slice of desired length (e.g., 7 or 14 characters)
$password = substr($shuffled, 0, 7);

echo $password . "<br>";

?>

<?php

/* 8 */

$sentence = 'That new trainee is so genius.';
$newWord = 'Our';

// Replace the first word (from beginning ^ up to the first space)
$result = preg_replace('/^\w+/', $newWord, $sentence);

echo $result . "<br>";

?>