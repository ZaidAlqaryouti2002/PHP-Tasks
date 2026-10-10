<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
</head>
<body>

    <form action="search.php" method="GET">
        <input type="text" name="q" placeholder="Search">
        <button type="submit">Search</button>
    </form>

<?php
 if (isset($_GET['q']) && !empty($_GET['q'])){

   $keyword = htmlspecialchars($_GET['q']);
   echo "<h3>Search result for: " . $keyword . "</h3>";
 }

 ?>

</body>
</html>