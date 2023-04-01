<?php

session_start();
@include 'config.php';

if (isset($_POST['submit'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = $_POST['password'];
  $user_type = "user";

  $select = " SELECT * FROM users WHERE email = '$email' ";

  $result = mysqli_query($conn, $select);

  if ($result && mysqli_num_rows($result) > 0) {

    $error[] = 'user already exist!';

  } else {
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
     
    $insert = "INSERT INTO users (name, email, password, user_type) VALUES('$name','$email','$hashed_password','$user_type')";
    mysqli_query($conn, $insert);
    header('location:home.php');
    $_SESSION['user_email'] = $email;
    $_SESSION['user_type'] = $user_type;
  

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
  <title>SIGN UP</title>
  <link rel="stylesheet" href="./css/usersignup.css">
  <script src="./js/index.js"></script>

</head>

<body>
  <div class='container'>
    <h1 class='login_heading'>GET A CAR TODAY ON RENT</h1> 
    <form action="" method="post" class='logincontainer'>
      <input placeholder='FULL NAME' name='name' type='text' />
      <input placeholder='MAIL' name='email' type='email' /> 
      <div class='passworddiv'>
        <input placeholder='PASSWORD' type='password' name="password" id='password' />
        <span id='passwordtoggle' onClick='togglePassword()'>Show</span>
      </div>
      <?php
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<span class="error-msg">' . $error . '</span>';
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
        <a class='linktext' href='signupagency.php'>Sign up as agency? </a>
    </form> 
  </div>
  </div>
  <div class='animation_box'>
    <img src='./img/205.svg' alt='car icon' />
  </div>
</body>

</html>