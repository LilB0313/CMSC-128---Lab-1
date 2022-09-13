<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Agahay Guesthouse Resort - Booking</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="OverAllStyle.css" type="text/css">
    <link rel="stylesheet" href="Booking.css" type="text/css">
  </head>

  <body>
    <!-- header -->
    <header>
      <div class="logo">
        <img src="images file\Logo.jpg">
      </div>
      <span>Agahay Guesthouse Resort</span>

      <!-- navigation -->
      <nav class="nav-links">
        <ul>
          <li><a href='#'>Home</a></li>
          <li><a href='#'><u style="color: black;">Booking</u></a></li>
          <li><a href='#'>Amenities</a></li>
          <li><a href='#'>About Us</a></li>
          <button id="btn1" class="button">Book Now</button>
        </ul>
      </nav>
      <!-- end of navigation -->

    </header>
    <!-- end of header -->

    <!-- fixed background -->
    <div id="slider">
      <ul id="slideWrap">                                                       <!-- an automated background slider -->
        <li><img src="images file\cover1.jpg" alt=""></li>
        <li><img src="images file\img 21.jpg" alt=""></li>
        <li><img src="images file\img 3.jpg" alt=""></li>
        <li><img src="images file\img 15.jpg" alt=""></li>
        <li><img src="images file\img 23.jpg" alt=""></li>
      </ul>

      <a id="prev" class="prev">&#10094;</a>                                    <!-- navigation arrows -->
      <a id="next" class="next">&#10095;</a>
    </div>
    <!-- end of cover picture -->

    <div class="container">
      <?php
        include 'DBConnector.php';
        // loads the feature for searching and edits
        include 'timeSlot.php';

        // if the users decides to check for the availability of bookings
        // checks if the search button was clicked
        if (isset($_POST['is_vacant'])) {
          // get the following data for search query
          $from_date = $_POST["from_date"];
          $to_date = $_POST["to_date"];

          // query in getting the table of booking reservation dates and stay type
          $sql = "SELECT stay_Date, set_No
                  FROM booking
                  WHERE stay_Date BETWEEN '$from_date' AND '$to_date'
                  ORDER BY stay_Date";
          $displayBooking = $conn -> query($sql);

          // runs if there are bookings
          if ($displayBooking -> num_rows > 0) {
            // displays the list of bookings
            echo "<div class='container-form'>".
              "<h1>List of Booked Dates</h1>".
              "<table style='width: 100%'>".
                 "<tr>".
                   "<th><h3>Dates</h3></th>".
                   "<th><h3>Stay Type</h3></th>".
                 "</tr>";

            // for every tuple in the of the $displayBooking table
            while ($showBooking = $displayBooking -> fetch_assoc()) {
              $set_type = $showBooking["set_No"];
              $query = "SELECT stay_Type, set_No
                      FROM staylist
                      WHERE set_No='$set_type'";
              $getStayType = $conn -> query($query);                            // we take the equivalent description of the stay type from stay_type table
              $showStayType = $getStayType -> fetch_assoc();

              // display the date with corresponding stay type
              echo "<tr>".
                "<td>".$showBooking["stay_Date"]."</td>".
                "<td>".$showStayType["stay_Type"]." (".$showStayType["set_No"].")</td>".
              "</tr>";
            }

            echo "</table>".
            "<br><hr><br>".
            "<p>The list above shows the booking date with its</p>".
            "<p>corresponding stay type. The number stands for</p>".
            "<p>each booking's specific choice of stay type.</p>".
            "<div class='container-form' style='padding:5%; float:right'>".
              "<button id='btn2' class='button'>Back</button>".
            "</div>".
            "</div>";
          } else {
            // else, print message and go back to form
            echo "<div class='container-form'>".
              "<section class='features'>".
                "<h4>No List of Bookings Yet</h4>".
                "<br><hr><br>".
                "<p>This date(s) had not been book yet. Book now and be the first to save a stay with us.</p>".
              "</section>".
              "<div class='container-form' style='padding:5%; float:right'>".
                "<button id='btn2' class='button'>Back</button>".
              "</div>".
            "</div>";
          }
        }
      ?>
    </div>

    <!-- the footer -->
    <footer class="contactus" style="top: 200px;">
      <h2>Contact Us</h2>
      <!-- links and resort info -->
      <ul>
        <a href="http://fb.com/agahayguesthouse">
          <img src="images file\icon 1.png">
        </a>
        <li><a href='http://fb.com/agahayguesthouse'>http://fb.com/agahayguesthouse</a></li>
        <img src="images file\icon 2.png">
        <li>09988848418</li>
        <img src="images file\icon 3.jpg">
        <li>renzad@yahoo.com</li>
      </ul>

      <span><i>© 2022 by Agahay Guesthouse</i></span>
    </footer>
    <!-- end of footer-->
    <script src="btn.js" type="text/javascript"></script>
    <script src="slider.js" type="text/javascript"></script>
  </body>
</html>
