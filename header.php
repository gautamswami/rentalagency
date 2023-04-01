 
<link rel="stylesheet" href="./css/header.css">
<div class='header flex_center'>
      <h1 class="logoheading"><a  href='home.php'>CARRENT</a></h1>
      <ul class='flex_center header_list'>
        <?php
        if ($_SESSION) {
            if($_SESSION['user_type']==='agency'){
                echo "<li> <a href='addvehicle.php'>ADD VEHICLE</a></li>
                <li> <a href='queriesagency.php'>BOOKED CARS</a></li>
                ";
            }
            echo " <li><a href='logout.php'>LOGOUT</a></li>";
        } else {
          echo "
          <li> <a href='login.php'>LOGIN</a></li>
          <li> <a href='signupuser.php'>SIGN UP</a></li>";
        }
       
        ?>
      </ul>

    </div>

    