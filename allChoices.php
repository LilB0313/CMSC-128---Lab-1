<?php
  // codes for the selection of set type

  include 'DBConnector.php';

  // get the details for every set
  $sql = "SELECT * FROM staylist";
  $result = $conn -> query($sql);

  // when done successfully
  if ($result -> num_rows > 0) {
    // print the set name together with their prices
    while ($row = $result -> fetch_assoc()) {
      echo "<option value ='".$row['set_No']."'>".$row['stay_Type']." - P".$row['price']."</option>";
    }
  } else {
    echo "0 results";
  }

  $conn -> close();
?>
