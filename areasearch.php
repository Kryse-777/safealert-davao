<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
  include "server.php";
  //Getting value of "search" variable from "areasearch.js".
  if (isset($_POST['areasearch'])) {
    //Search box value assigning to $areaname variable.
    $areaname = $_POST['areasearch'];
    $query = "SELECT * FROM riskarea WHERE area LIKE '%$areaname%' LIMIT 5";
    $execquery = mysqli_query($safealertdb, $query);

    //Creating unordered list to display result.
    echo '<ul class="searchlist">';

    //Fetching result from database.
    while ($result = mysqli_fetch_array($execquery)) {
    ?>

    <!-- Create unordered list items.

      Call javascript function "fill" in "areasearch.js" file.

      By passing fetched result as parameter. -->
    <li class="searchlistitem" onclick='fill("<?php echo $result['area']; ?>")'>
    <a>

    <!-- Assigning searched result in "Search box" in "search.php" file. -->
    <?php
      echo "Area Name: " . $result['area'] . "</br>";
      echo "Risk: " . $result['risk'] . "</br>";
      echo "Coordinates: " . $result['coordinates'] . "</br>";
    ?>

    </li>
    </a>

    <!-- code for closing parenthesis -->
    <?php
  }
}
?>
</ul>
</body>
</html>