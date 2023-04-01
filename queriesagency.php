<?php
session_start();
require('config.php');
$owner_email = $_SESSION['user_email'];
$sql =
    "SELECT bookings.id,bookings.days,bookings.start_date,bookings.user_email, vehicles.vehicle_model, vehicles.vehicle_number
            FROM bookings
            INNER JOIN vehicles ON bookings.car_id = vehicles.id
            WHERE bookings.owner_email = '$owner_email'";

$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Queries</title>
    <link rel="stylesheet" href="./css/query.css">
</head>

<body>

    <div class='container'>
        <?php
        include('header.php');

        

if ($result && mysqli_num_rows($result) > 0) {
      echo"  <table>
            <thead>

                <tr>
                    <th>Booking id</th>
                    <th>Car model</th>
                    <th>Car number</th>
                    <th>Days required</th>
                    <th>Start Date</th>
                    <th>Sender mail</th>
                </tr>
            </thead>";
}
?>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
            <tbody>
                <tr>
                    <td>
                        <p>$row[id]</p>
                    </td>
                    <td>
                        <p>$row[vehicle_model]</p>
                    </td>
                    <td>
                        <p>$row[vehicle_number]</p>
                    </td>
    
                    <td>
                        <p>$row[days] </p>
                    </td>
                    <td>
                        <p>$row[start_date]</p>
                    </td>
                    <td>
                        <p>$row[user_email]</p>
                    </td>
    
                </tr>
    
            </tbody>
            ";
                }
            } else {
                echo "
                <div class='noquery_div'>
                NO VEHICLE QUERIES
                <br/>
                <button class='add_button'> <a href='addvehicle.php'>ADD MORE VEHICLES</a></button>
                </div>
                ";
            }
            ?>
        </table>
    </div>
</body>

</html>