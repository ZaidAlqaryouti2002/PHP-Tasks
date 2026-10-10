<?php

/* 1 
we use sort to sort the array alphabetically
implode function takes array and glues them together 
*/
 $colors = ["white", "green", "red"];
 sort($colors); 
 echo "Sorted Array is " . "</br>". implode(" ",$colors). "</br>";
?>


<?php

 /* 2
 we use asort to sort the capital alphabetically while keeping the linking with their keys because the normal sort function restructure the array and sort the keys from 0 to etc...
 */

   $cities = ["Italy" => "Rome", "Luxemborg" => "Luxemborg", "Belguim" => "Brussels", "Denmark" => "Copenhagen", "Finland" => "Helsinki", "Frane" => "Paris", "Slovakia" => "Bratislava", "Slovenia" => "Ljubljana", "Germany" => "Berlin", "Greece" => "Athens", "Ireland"=>"Dublin", "Netherlands" => "Amestardam", "Portugal" => "Lisbon", "Spain" => "Madrid"];
     
   asort($cities);

   foreach ($cities as $country =>$capital){
    echo "The Capital of " . $country . " is ". $capital. "<br>";
   }

 ?>

 <?php

   /* 3 */

   $color = [4 => 'white', 6 => 'green', 11=> 'red'];
    
   echo $color[4];

  ?>

  <?php
   /* 4 */
   $arr = [1, 2, 3, 4, 5];
   $location = 4;
   $newItem = '$';
   $target = $location-1;
   array_splice($arr, $target, 0, $newItem);
   echo implode("",$arr)."<br>";
  ?>

  <?php
  /* 5 */
  $fruits = ["d" => 'lemon', "a"=>'orange', "b" => 'banana', "c" => 'apple'];
  asort($fruits);
  foreach($fruits as $key => $value){
    echo $key. "=". $value. "<br>";
  }

  ?>

  <?php
  /* 6 */
    $recorded_temps = [
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64,
    76, 63, 75, 76, 73, 68, 62, 73, 72, 65,
    74, 62, 62, 65, 64, 68, 73, 75, 79, 73
    ];

    $average = array_sum($recorded_temps) / count($recorded_temps);

    echo "Average Tempreture is : ". round($average,1) . "<br>";
   
    sort($recorded_temps);

    $lowest_temps = array_slice($recorded_temps, 0, 4);
    echo "List of five lowest temperatures: " . implode(", ", $lowest_temps) . "<br>";


    $highest_temps = array_slice($recorded_temps, -5);
    echo "List of five highest temperatures: " . implode(", ", $highest_temps) . "<br>";


  ?>


   <?php
    /* 7 */

    $array1 = array("color" => "red", 2, 4);
    $array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);

    $mergerdArray = array_merge($array1, $array2);

    print_r($mergerdArray)."<br>";

  ?>  

  <?php

    
   
   function convertToUpperCase($array) {
    return array_map('strtoupper', $array);
   }

   $colors = array("red", "blue", "white", "yellow");

   $result = convertToUpperCase($colors);

   print_r($result);

  ?>