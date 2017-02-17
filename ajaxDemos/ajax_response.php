<?php
// Display Output
// this file has no doctype and will never leave the Server
// it simply runs a query and returns the text content for our INTERFACE
require('db_config.php');
//this variable will be sent to the file via js or (in our url window)
$category_id = $_REQUEST['category_id']; //Trish's Opinion: use get instead
//query to get all published posts from that category
//needs category id in order to run query
$query = "SELECT posts.title, posts.body, users.username, posts.date
          FROM posts, users
          WHERE posts.user_id = users.user_id
          AND posts.category_id = $category_id
          ORDER BY date DESC";
//run it
$result = $db->query($query);
//check it
if(! $result){
  echo $query.'<br />';
  echo $db->error;
}
?>
<h2><?php echo $result->num_rows; ?> Posts Found</h2>
<?php
//check it
if($result->num_rows>=1){
  while ($row = $result->fetch_assoc()) {
    //fetch_assoc means fetch the associated lists within the field requested
?>
<article>
  <h3><?php echo $row['title']; ?></h3>
  <h4>by <?php echo $row['username']; ?></h4>
  <p><?php echo $row['body']; ?></p>
</article>
<?php
  }//end of ze while
}//end of the if statement
 ?>
