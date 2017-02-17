<?php
$host = 'localhost';
$username = 'ariel_blog';
$password = 'mm3fyVQncEdbrKtE';
$database = 'ariel_blog';
//connect to database
$db = new mysqli( $host, $username, $password, $database );

//check to make sure it works!
if($db->connect_errno > 0){
  die('Cant connect to ze Database. Try again Laters.');
}
