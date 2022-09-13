<?php
  // code for adding Customer Details and Booking Details into their respective tables
  // also calculates for the total bill of the reservation

  include 'DBConnector.php';
  session_start();

  if (isset($_POST['book'])) {
    // get the date for reservation
    $date = $_POST["date"];

    // check if there are any exisitng bookings on that day
    $check = "SELECT stay_Date
              FROM booking
              WHERE stay_Date='$date';";
    $is_booked = $conn -> query($check);

    // if there is
    if ($is_booked -> num_rows > 0) {
      echo "<section class='features'>".
          "<h4>Sorry, Date Already Booked!</h4><br>".
        "</section>";
    }

    // get the data for the customer table
    $name = $_POST["name"];
    $number = $_POST["number"];
    $address = $_POST["address"];

    $sql = "INSERT INTO customer (cust_ID, cust_Name, cust_Address, contact_No)
            VALUES (NULL, '$name', '$address', '$number');";                    // Cust. ID is null because it is automatically incremented in the database (primary key)
    $save_cust = $conn -> query($sql);                                          // add it into the table

    // if the insertion of customer detail was successful
    if ($save_cust) {
      $last_id = $conn -> insert_id;                                            // get the data for the booking table
      $stay = $_POST["stay"];
      $guest_no = $_POST["guest_no"];

      $_SESSION["id"] = "$last_id";                                             // save the Cust. ID into a session as a place holder
      $query = "INSERT INTO booking (cust_ID, set_No, guest_No, stay_Date, booking_No)
                VALUES ('$last_id', '$stay', '$guest_no', '$date', NULL);";     // add the data into the booking table
      $save_booking = $conn -> query($query);

      // if the insertion of booking detail was successful
      if ($save_booking) {
        $last_no = $conn -> insert_id;

        $search = "SELECT price, max_People
                FROM staylist
                WHERE set_No='$stay';";                                         // get the price and maximum number of people from the staylist table
        $details = $conn -> query($search);                                     // the set_No is what the customer reserved for

        // if the details were retrieved successfully
        if ($details) {
          $check_max = $details -> fetch_assoc();
          $max = $check_max["max_People"];                                      // fetch these data
          $price = $check_max["price"];

          // if the guest_no indicated by the users exceed the limit
          if ($guest_no > $max) {
            $add_on_guest = $guest_no - $max;                                   // count the number of extra people
            $add_on = $add_on_guest * 75;                                       // by default, the entrance fee is 75 pesos
            $total = $price + $add_on;                                          // add this to get the total bill of the customer

            // if it is within the range
          } else {
            $total = "$price";                                                  // save the total in a session
          }

          if ($total) {
            $_SESSION["total"] = "$total";
            $query = "INSERT INTO transaction (cust_ID, booking_No, Cost)
                      VALUES ('$last_id', '$last_no', '$total');";              // add these details into the transaction table
            $save_transaction = $conn -> query($query);
          }
        }
      }
    } else {
      echo "Failed to process.";                                                // when the process unexpectedly ends, load this message
    }

    // once successful, change to this location
    header("Location:Booked.php");
  } else {
      echo "Error ".$sql . "<br/>" . $conn -> error;                            // runs if error was encountered
  }
 ?>
