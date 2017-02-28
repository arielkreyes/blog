<?php
error_reporting( E_ALL & ~E_NOTICE );
$host = 'localhost';
$username = 'ariel_blog';
$password = 'mm3fyVQncEdbrKtE';
$database = 'ariel_blog';
//connect to database
$db = new mysqli( $host, $username, $password, $database );

//check to make sure it works!
if($db->connect_error > 0){
  die('Cant connect to ze Database. Try again Laters.');
}
//hashes and salts for making passwords stronger! >:) keep zis a secret!
define('SALT', 'aklsefhkasdfjklast9we45t89w3');
