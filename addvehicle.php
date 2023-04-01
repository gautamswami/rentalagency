<?php
session_start();
require_once('config.php');
$email = $_SESSION['user_email'];
$vehicledata = array();
if (isset($_SESSION['user_email']) && $_SESSION['user_type'] == 'agency') {
  //  if user is already logged in get data of the user
  $sql = "SELECT * FROM vehicles WHERE owner_email = '$email'";
  $result = mysqli_query($conn, $sql);

}
//redirect to home if not a login or not agency
else if ($_SESSION['user_type'] !== 'agency') {
  header('Location: home.php');
}

// // Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['model']) && !empty($_POST['number']) && !empty($_POST['seat']) && !empty($_POST['rent'])) {
  // Get form data
  $model = $_POST['model'];
  $number = $_POST['number'];
  $seat = $_POST['seat'];
  $rent = $_POST['rent'];
  $id = $_POST['submit'];
  $sql = "SELECT * FROM vehicles WHERE vehicle_model = '$model' AND vehicle_number = '$number' AND vehicle_seats = '$seat' AND vehicle_rent = '$rent'";
  $getvehicle = $conn->query($sql);
  $model = mysqli_real_escape_string($conn, $model);
  $number = mysqli_real_escape_string($conn, $number);
  $seat = mysqli_real_escape_string($conn, $seat);
  $rent = mysqli_real_escape_string($conn, $rent);
  $id = mysqli_real_escape_string($conn, $id);
  if ($getvehicle->num_rows > 0) {
    echo "Vehicle already added";
  } else {
    if ($id == "") {
      $insert = "INSERT INTO vehicles (vehicle_model, vehicle_number	, vehicle_seats, vehicle_rent ,owner_email) VALUES ('$model','$number','$seat','$rent','$email')";
    } else {
      $insert = "UPDATE vehicles
      SET vehicle_model = '$model', vehicle_number = '$number', vehicle_seats = '$seat', vehicle_rent ='$rent'
      WHERE id = $id";
    }
 
    if ($conn->query($insert) === false) {
      echo "Error: " . $conn->error;
    } else {
      echo "Data saved successfully";
    }
  }
  // close database connection
  $conn->close();

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADD CAR</title>
  <link rel="stylesheet" href="./css/addvehicle.css">
  <script src="./js/index.js"></script>
</head>

<body>
  <div class='container'>
    <?php
    include('header.php');
    ?>

    <div class='form_container'>
      <h3 id="add_heading">ADD VEHICLE</h3>

      <form class='vehicle_form' action="" method='post'>
        <input id='model' placeholder='Enter vehicle model' name='model' />
        <input id='number' placeholder='Enter vehicle number' name='number' />
        <input id='seat' placeholder='Enter seating capacity' type='number' name='seat' />
        <div class="rent_div">
        <input id='rent' placeholder='Enter rent per day' type='number' name='rent' />
        <span class='currency_span'>$ per day</span></div>
        <button class='login_button' id='add_button' value="" name='submit' type='submit'>+ ADD</button>
      </form>
      <button id='cancel_button' onclick='editVehicle({"action":"cancel"})'>CANCEL</button>
    </div>
    <div class='card_container'>
      <?php
      if ($result && mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

          echo "<div class='logincontainer'>
          <h1>$row[vehicle_model]</h1>
          <h4>Number : $row[vehicle_number]</h4>
          <p>Seats : $row[vehicle_seats]</p>
          <h3>$ $row[vehicle_rent]</h3>
          <button class='login_button' onclick='editVehicle(" . json_encode($row) . ")'>Edit</button>
          </div>";
        }
      } else {
        echo "NO RESULT";
      }
      ?>
    </div>

  </div>


</body>

</html>