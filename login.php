<?php
//require same as include except if the code fails the page is killed
require('login_parser.php');
include_once('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="admin/css/admin-style.css">
  <title>Login System</title>
</head>
<body>

  <?php
  //Lets you look at the post array (wrap in <pre> tag for better reading)
  // print_r($_POST); ?>

  <h2>Login to your account.</h2>
  <?php echo $feedback; ?>

  <form class="form-login" action="login.php" method="post">

    <label for="login-username">Username:</label>
    <input id="login-username" type="text" name="username" value="" autofocus required>

    <label for="login-password">Password:</label>
    <input id="login-password" type="password" name="password" value="" required>

    <input type="submit" name="submit" value="Log In">
    <input type="hidden" name="did_login" value="true">

  </form>

</body>
</html>
