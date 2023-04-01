<?php

session_start();
@include 'config.php';

if (isset($_POST['submit'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $pass = $_POST['password'];
  $user_type = "agency";
   if (!filter_var($email, FILTER_VALIDATE_EMAIL) && empty($name) && empty($phone) && empty($pass)) {
    $error[] = 'Invalid input!';
  }
  else{
  $select = " SELECT * FROM users WHERE email = '$email' ";

  $result = mysqli_query($conn, $select);

  if ($result && mysqli_num_rows($result) > 0) {

    $error[] = 'user already exist!';

  } else {
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $insert = "INSERT INTO users (name, email, password, user_type) VALUES('$name','$email','$hashed_password','$user_type')";
    $res = mysqli_query($conn, $insert);
    header('location:home.php');
    $_SESSION['user_email'] = $email;
    $_SESSION['user_type'] = $user_type;
  }
  }
}
;


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AGENCY SIGNUP</title>
  <link rel="stylesheet" href="./css/usersignup.css">
  <script src="./js/index.js"></script>

</head>

<body>
  <div class='container'>
    <h1 class='login_heading'>RENT YOUR CARS LIKE NEVER BEFORE!</h1>

    <form action="" method="post" class='logincontainer'>
      <input placeholder='AGENCY NAME' name='name' type='text' />
      <input placeholder='MAIL' name='email' type='email' />
      <input placeholder='PHONE NUMBER' name='phone' type='text' pattern="[789][0-9]{9}" />
      <div class='passworddiv'>
        <input placeholder='PASSWORD' type='password' name="password" id='password' />
        <span id='passwordtoggle' onClick='togglePassword()'>Show</span>
      </div>
      <?php
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<span class="error_msg">' . $error . '</span>';
        }
        ;
      }
      ;
      ?>
      <button class='login_button' name="submit" type="submit">SIGN UP</button>
      <div class='newuser_div'>
        <p>Already have an account? <a class='linktext' href='login.php'>Login</a></p>
        <br />
        <div class='flex'>
          <hr />
          <p>OR</p>
          <hr />
        </div>
        <br />
        <a class='linktext' href='signupuser.php'>Sign up as user? </a>
    </form>
  </div>
  </div>
  <div class='animation_box'>
    <img src='./img/205.svg' alt='car icon' />
  </div>
</body>

</html>