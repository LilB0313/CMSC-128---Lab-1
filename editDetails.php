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
        session_start();

        // jumps to timeSlot.php to load service hours
        include 'timeSlot.php';

        // displays the form for editing the cust_details
        // first, checks if the users clicked the verify button
        if (isset($_POST['verify'])) {
          $id = $_POST["ID"];                                                   // saves the CustID needed for verification
          $_SESSION["CustID"] = $id;                                            // save a session of id as a place holder

          $sql = "SELECT *
                  FROM customer
                  WHERE cust_ID='$id';";
          $get_cust = $conn -> query($sql);

          // runs if the CustID exist in the database
          if ($get_cust -> num_rows > 0) {
            $value_cust = $get_cust -> fetch_assoc();

            $query = "SELECT *
                      FROM booking
                      WHERE cust_ID='$id';";
            $get_booking = $conn -> query($query);                              // gets the data from booking table

            // if data was retrieved successfully
            if ($get_booking) {
              $value_booking = $get_booking -> fetch_assoc();

              // display the form with the previous data entry
              echo "<div class='container-form'>".
                "<form action='editDetails.php' method='post'>".
                  "<h1>Edit Details</h1>".
                  "<div class='form-field'>".
                    "<label for='name'>Full Name</label>".
                    "<input type='text' id='name' value='".$value_cust["cust_Name"]."' name='name'>".
                  "</div>".
                  "<div class='form-field'>".
                    "<label for='email'>Contact Number</label>".
                    "<input type='text' id='email' value='".$value_cust["contact_No"]."' name='number'>".
                  "</div>".
                  "<div class='form-field'>".
                    "<label for='adr'>Address</label>".
                    "<input type='text' id='adr' value='".$value_cust["cust_Address"]."' name='address'>".
                  "</div>".
                  "<div class='form-field'>".
                    "<label for='date'>Stay Date</label>".
                    "<input type='date' value='".$value_booking["stay_Date"]."' name='date'>".
                  "</div>".
                  "<div class='form-field'>".
                    "<p>No. of Guest</p>".
                    "<input type='number' value='".$value_booking["guest_No"]."' name='guest_no'>".
                  "</div>".
                  "<div class='form-field'>".
                    "<p>Stay Type</p>".
                    "<select class='expand' value='".$value_booking["set_No"]."' name='stay'>".
                      "<option value='' disabled=''>--Select Set--</option>";
                      include 'allChoices.php';
                    echo "</select>".
                  "</div>".
                  "<div class='form-field'>".
                    "<button type='cancel' name='disregard_change' class='btn'>Cancel</button>".
                    "<button type='submit' name='save_changes' class='btn'>Save Record</button>".
                  "</div>".
                "</form>".
              "</div>";
            }
          } else {
            // else, print message and go back to form
            echo "<div class='container-form'>".
              "<section class='features'>".
                "<h4>Incorrect ID</h4>".
                "<br><hr><br>".
                "<p>Sorry, this Customer Reference ID does not exist in our database. Please try again later.</p>".
              "</section>".
              "<div class='container-form' style='padding:5%; float:right'>".
                "<button id='btn2' class='button'>Back</button>".
              "</div>".
            "</div>";
          }
        }

        // if the users cancel the edits the have done
        // return to employees.php
        if (isset($_POST['disregard_change'])) {

          // if editing the details of customer was cancelled
          echo "<div class='container-form'>".
            "<section class='features'>".
              "<h4>Data Editing Cancelled</h4>".
              "<br><hr><br>".
              "<p>Rest asured, your personal information are kept safe.</p>".
            "</section>".
            "<div class='container-form' style='padding:5%; float:right'>".
              "<button id='btn2' class='button'>Back</button>".
            "</div>".
          "</div>";
        }

        // if they wish to save the edits they added into the information of the customers
        if (isset($_POST['save_changes'])) {
          // retrieve the values set in the form (the form above)
          $id = $_SESSION["CustID"];
          $name = $_POST["name"];
          $number = $_POST["number"];
          $address = $_POST["address"];
          $date = $_POST["date"];
          $guest_no = $_POST["guest_no"];
          $stay = $_POST["stay"];

          // manipulate the records in customer table by updating the entire tuple where CustID = '$id'
          // the values for each column are taken from the form
          $sql = "UPDATE customer
                  SET cust_Name='$name', contact_No='$number', cust_Address='$address'
                  WHERE cust_ID='$id';";
          $updateCust = $conn -> query($sql);

          // runs when the data manipulation was successfully executed
          if ($updateCust) {
            // manipulate the records in booking table by updating the entire tuple where CustID = '$id'
            $query = "UPDATE booking
                      SET set_No='$stay', guest_No='$guest_no', stay_Date='$date'
                      WHERE cust_ID = '$id';";
            $updatebooking = $conn -> query($query);

            // if the insertion of booking detail was successful
            if ($updatebooking) {
              $search = "SELECT price, max_People
                      FROM staylist
                      WHERE set_No='$stay';";                                       // get the price and maximum number of people from the stay_type table
              $details = $conn -> query($search);                                     // the Set_Type is that of the customer's reservation

              // if the details were retrieved successfully
              if ($details) {
                $check_max = $details -> fetch_assoc();
                $max = $check_max["max_People"];                                       // fetch these data
                $price = $check_max["price"];

                // if the guest_no indicated by the users exceed the limit
                if ($guest_no > $max) {
                  $add_on_guest = $guest_no - $max;                                   // count the number of extra people
                  $add_on = $add_on_guest * 75;                                       // by default, the entrance fee is 75 pesos
                  $total = $price + $add_on;                                          // add this to get the total bill of the customer
                  $price = $total;                                                    // save the total
                }

                $sql = "UPDATE transaction
                        SET cost='$price'
                        WHERE cust_ID='$id';";                                         // update the transaction cost
                $updateTransaction = $conn -> query($sql);
              }
            }
            // if editing the details of customer was successful
            echo "<div class='container-form'>".
              "<section class='features'>".
                "<h4>Data Editted Successfully</h4>".
                "<br><hr><br>".
                "<p>All changes had been saved in our list. Your current payment is P", $price, ". Thank you, and see you soon!</p>".
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
