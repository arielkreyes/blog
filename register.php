<?php
error_reporting( E_ALL & ~E_NOTICE );
//conect to database
require('db_config.php');
//use _once on function definitions to prevent duplicates and breakin' yo shit.
include_once('functions.php');
//begin parser
if($_POST['did_register']){
  //sanitize errthang
  $username = clean_string($_POST['username']);
  $email = clean_email($_POST['email']);
  $password = clean_string($_POST['password']);
  $policy = clean_integer($_POST['policy']);
  //validate:
  $valid = 1;
    //username wrong length
    if(strlen($username) < 5 OR strlen($username) > 40 ){
      $valid = 0;
      $errors['username'] = 'Choose a username between 5 and 40 characters long';
    }else{
      //username already taken
      $query = "SELECT username FROM users
                WHERE username = '$username'
                LIMIT 1";
      //RUN IT
      $result = $db->query($query);
      //check it
      if($result->num_rows == 1){
        $valid = 0;
        $errors['username'] = 'Sorry, that username is already in use. Choose Another.';
      }//end of if statement query
    }//end of if statement strlen
    //password wrong Length
    if(strlen($password) < 8 ){
      $valid = 0;
      $errors['password'] = 'Your Password needs to be at least 8 characters.';
    }
    //email wrong format
    if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
      $valid = 0;
      $errors['email'] = 'Please provide a valid email.';
    }else{
      //email already taken
      $query = "SELECT email FROM users
                WHERE email = '$email'
                LIMIT 1";
      //run it
      $result = $db->query($query);
      if($result->num_rows == 1){
        $valid = 0;
        $errors['email'] = 'That email is already registered. Do you want to log in?';
      }//end of if result num rows
    }
    //policy box not check
    if($policy !=1){
      $valid = 0;
      $errors['policy'] = 'You must agree to our terms before signing up. -_-';
    }//end of if statement
  //if valid, add teh user to teh users table! ^_^
  if($valid){
    //add salt to make it harder to hack passwords
    $password = sha1($password . SALT);
    $query = "INSERT INTO users
              (username, password, email, is_admin, is_approved)
              VALUES
              ('$username','$password', '$email', 0, 0 )";
              //hashing the password heya. "sha1()"
    //run it
    $result = $db->query($query);
    //if worked, tell them to wait for confirmation, redirect to login
    if( $db->affected_rows == 1){
      //affected rows would be stated during the //check it part of the process in the select statement. used for update, insert, and delete
      $feedback = 'You are now signed up! As soon as you are approved by an admin, you can log in. :)';
    }else{
      //if it failed, show user feedback
      $feedback = 'Sorry, your account was not created. :(';
    }//end of else statement
  }//end of if validate
  else{
    $feedback = 'There are errors in the form, please fix them and try again.';
  }//end of else
}//end of if did register
//end parser
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sign Up For Your Account</title>
    <link rel="stylesheet" href="admin/css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic">
  </head>
  <body class="login">
    <h2>Create Your Account</h2>
    <?php show_feedback($feedback, $errors); ?>
    <form action="register.php" method="post">
      <label for="the_username">Choose a Username</label>
      <input type="text" name="username" id="the_username" />
      <span class="hint">Between 5 - 40 Characters</span>
      <label for="the_email">Email Address</label>
      <input type="email" name="email" id="the_email" />
      <label for="the_password">Choose a Password</label>
      <input type="password" name="password" id="the_password" />
      <span class="hint">At Least 8 Characters Long</span>
      <label>
        <input type="checkbox" name="policy" value="1" />
        I agree to the <a href="#" target="_blank">terms of service and privacy policy.</a>
      </label>
      <input type="submit" value="Sign Up" />
      <input type="hidden" name="did_register" value="1" />
    </form>
  </body>
</html>
