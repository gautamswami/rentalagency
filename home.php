<?php
session_start();
require_once('config.php');
$vehicledata = array();
// get data of vehicles
$sql = "SELECT * FROM vehicles";
$result = mysqli_query($conn, $sql);
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['owner_mail']) && !empty($_POST['days']) && !empty($_POST['date'])) {
  if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == 'user') {
      $carid = $_POST['submit'];
      $ownermail = $_POST['owner_mail'];
      $usermail = $_SESSION['user_email'];
      $days = $_POST['days'];
      $date = $_POST['date'];
      $insert = "INSERT INTO bookings (car_id, owner_email	, user_email, days , start_date) VALUES 
    ('$carid','$ownermail','$usermail','$days','$date')";

      if ($conn->query($insert) === false) {
        echo "Error: " . $conn->error;
      } else {
        $err = "QUERY SENT";
      }
    } else if ($_SESSION['user_type']) {
      $err = "YOU ARE AGENCY";
    }
  } else {
    header('Location:login.php');
  }
}
else{
  $err = "Please select date and days";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CARS FOR RENT</title>
  <link rel="stylesheet" href="./css/home.css">
</head>

<body>


  <div class='container'>
    <?php
    include('header.php');
if($err){
    echo "<div class='toast'>
    $err
</div> ";}
    ?>
    <div class='card_container'>
      <?php
      if ($result && mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          echo "
          <div class='logincontainer'>
          <h2>$row[vehicle_model]</h2>
          <h4>Number : $row[vehicle_number]</h4>
          <p>Seats : $row[vehicle_seats]</p>
          <h3>$$row[vehicle_rent]</h3>
          <form action='' method='post' class='days_form'>
          ";
          if ($_SESSION && $_SESSION['user_type']) {
            echo "
            <input class='login_button' type='date' name='date'/>
            <input type='hidden' name='owner_mail' value='$row[owner_email]'>
        <select name='days'>
          <option value='1'>1 days</option>
          <option value='2'>2 days</option>
          <option value='3'>3 days</option>
          <option value='4'>4 days</option>
          <option value='5'>5 days</option>
          <option value='6'>6 days</option>
          <option value='7'>More than 7 days</option>
        </select>
        ";
          }

          echo "<button class='login_button' name='submit' value='$row[id]' type='submit'>RENT NOW</button>
          </form>
      </div>";
        }
      } else {
        echo "<div class='noquery_div'>
        NO CARS AVAILABLE FOR RENT CURRENTLY
        <br/>
        </div>";
      }
      ?>

    </div>

  </div>
  </div>

</body>

</html>