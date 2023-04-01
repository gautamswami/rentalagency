<?php
// Start session
session_start();
 
require_once "config.php";

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect to home
  header('Location: home.php');
  exit;
}

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Retrieve user data from database
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  // Verify password
  if ($user && password_verify($password, $user['password'])) {
    // Password matches, log the user in
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['user_email'] = $user['email'];
  

    header('Location: home.php');
    exit;
  } else {
    // Password does not match, display error message
    $error[] = 'Invalid email or password';
  }
}
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet" href="./css/login.css">
  <script src="./js/index.js"></script>
</head>

<body>
  <div class='container'>
  </div>
  <div class='box'>
    <h1 class='login_heading'>Welcome Back!</h1>
    <form action="" method="post" class='logincontainer'>

      <input placeholder='MAIL' name="email" type='email' />
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
      <button class='login_button' name='submit' type='submit'>LOGIN</button>
      <div class='newuser_div'>
        <p>New here? <a class='linktext' href='signupuser.php'>Create account</a></p>
        <br />
        <div class='flex'>
          <hr />
          <p>OR</p>
          <hr />
        </div>
        <br />
        <a class='linktext' href='signupagency.php'>Sign up as agency? </a>
      </div>
    </form>
  </div>
    
  <div class='animation_box'>
    <img src='./img/205.svg' alt='car icon' />
  </div>
</body>

</html>