<?php
// Display Output
// this file has no doctype and will never leave the Server
// it simply runs a query and returns the text content for our INTERFACE
require('db_config.php');
//this variable will be sent to the file via js or (in our url window)
$category_id = $_REQUEST['cat_id']; //Trish's Opinion: use get instead
//query to get all published posts from that category
$query = "SELECT posts.title, posts.body, users.username
          FROM posts, users
          WHERE "
 ?>
