<?php
  // php code for the time slot
  // to avoid redundancy in the codes, and ease in cleaning

  include 'DBConnector.php';

  // contains the details for opening time, pool time and contact info
  echo "<div class='container-time'>".
    "<h1>Time Open</h1>".
    "<hr>".
    "<h3>Monday-Sunday</h3>".
    "<p>Day use - Check-in: 12:00nn to 8:00pm</p>".
    "<p>Overnight - Check-in: 2:00pm</p>".
    "<p>Check-out: on/before 12:00nn next day</p>".
    "<h3>POOL TIME</h3>".
    "<p>7:00am to 10:30pm</p>".
    "<p>(beyond 10:30pm closed for maintenance)</p><br>".
    "<hr>".
    "<br><h4>Call Us: 09988848418</h4>".
  "</div>";
?>
