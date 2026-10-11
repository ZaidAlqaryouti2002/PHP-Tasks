<?php
/* 1 */
// Calculate and print the Fibonacci sequence using a for loop
$terms = 10;
$num1 = 0;
$num2 = 1;
$sequence = [];

for ($i = 0; $i < $terms; $i++) {
    $sequence[] = $num1;
    $next = $num1 + $num2;
    $num1 = $num2;
    $num2 = $next;
}

echo implode(', ', $sequence);
?>

<?php
/* 2 */
// Generate and display the first n lines of a Floyd triangle
$n = 5;
$count = 1;

for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo $count . " ";
        $count++;
    }
    echo "<br>";
}
?>

<?php
/* 3 */
// Print the alphabetical diamond pattern.
$rows = 5;

// Upper half of the diamond
for ($i = 1; $i <= $rows; $i++) {
    // Print leading spaces for HTML browser alignment
    echo str_repeat("&nbsp;&nbsp;", $rows - $i);
    
    $char = 'A';
    for ($j = 1; $j <= $i; $j++) {
        echo $char . "&nbsp;&nbsp;";
        $char++;
    }
    echo "<br>";
}

// Lower half of the diamond
for ($i = $rows - 1; $i >= 1; $i--) {
    // Print leading spaces for HTML browser alignment
    echo str_repeat("&nbsp;&nbsp;", $rows - $i);
    
    $char = 'A';
    for ($j = 1; $j <= $i; $j++) {
        echo $char . "&nbsp;&nbsp;";
        $char++;
    }
    echo "<br>";
}
?>