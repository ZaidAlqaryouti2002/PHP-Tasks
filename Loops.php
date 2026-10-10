<?php
/*1*/
for ($x =1; $x<=10; $x++){
    echo "Number: ". $x . "<br>";
}
?>

<?php
/*2*/
 $sum =0;
 for($x=0; $x<=30; $x++){
   $sum+=$x;
 }
 echo $sum. "<br>";

?>

<?php

/* 3 */

$letters = array('A', 'B', 'C', 'D', 'E');

for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        // Print A for the leading positions otherwise print the current row letter
        if ($j < 4 - $i) {
            echo "A ";
        } else {
            echo $letters[$i] . " ";
        }
    }
    echo "<br>";
}

?>

<?php

/* 4 */

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        // Print 1 for the leading positions otherwise print the row number
        if ($j <= 5 - $i) {
            echo "1 ";
        } else {
            echo $i . " ";
        }
    }
    echo "<br>";
}

?>

<?php

/* 5 */

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        // Print the row number on the diagonal otherwise print 0
        if ($i === $j) {
            echo $i . " ";
        } else {
            echo "0 ";
        }
    }
    echo "<br>";
}

?>

<?php
 /*6*/

 $number =5;
 $factorial=1;

 for($i = $number; $i >= 1; $i--){
    $factorial*= $i;
 }

 echo $factorial . "<br>";

?>

<?php

/* 7 */

echo '<table border="1" cellpadding="3px" cellspacing="0px">';

// Outer loop for rows (1 to 6)
for ($i = 1; $i <= 6; $i++) {
    echo "<tr>";
    
    // Inner loop for columns (1 to 5)
    for ($j = 1; $j <= 5; $j++) {
        $result = $i * $j;
        echo "<td>$i * $j = $result</td>";
    }
    
    echo "</tr>";
}

echo "</table>";

?>
