<?php
  // file for the reservation form

  include 'DBConnector.php';

  echo "<div class='container-form'>".
    "<form action='http://localhost/lab1/addCust.php' method='post'>".
      "<h1>Book Your Stay</h1>".
      "<div class='form-field'>".
        "<p>Full Name</p>".
        "<input type='text' placeholder='Enter Name' name='name'>".
      "</div>".
      "<div class='form-field'>".
        "<p>Contact Number</p>".
        "<input type='text' placeholder='Enter Number' name='number'>".
      "</div>".
      "<div class='form-field'>".
        "<p>Address</p>".
        "<input type='text' placeholder='Enter Address' name='address'>".
      "</div>".
      "<div class='form-field'>".
        "<p>Stay Date</p>".
        "<input type='date' name='date'>".
      "</div>".
      "<div class='form-field'>".
        "<p>No. of Guest</p>".
        "<input type='number' placeholder='Enter Number' name='guest_no'>".
      "</div>".
      "<div class='form-field'>".
        "<p>Stay Type</p>".
        "<select class='expand' name='stay'>".
          "<option value='' disabled=''>-- Select a Set Plan --</option>";
          include 'allChoices.php';                                             // gets the list of sets available
          echo "<option value='' disabled=''>-- Descriptions are in About Us --</option>".
        "</select>".
      "</div>".
      "<button type='submit' id='btn3' name='book'>Book Now</button>".
    "</form>".
  "</div>";
?>
