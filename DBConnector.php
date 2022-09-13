<?php
  // the connector to enable us to use xampp

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lab1";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>
