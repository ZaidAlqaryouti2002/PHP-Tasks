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
   echo implode("",$arr);
  ?>