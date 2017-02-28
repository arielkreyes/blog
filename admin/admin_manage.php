<?php
session_start();
require('../db_config.php');
include_once('../functions.php');

//header contains the security check, doctype, and <header> element
include('admin_header.php');
include('admin_nav.php');
//parse the deleting butttoon
if($_POST['did_delete']){
  //which boxes did they check???
  $list = $_POST['delete'];
  foreach($list as $post_id){
    $query = "DELETE FROM posts
              WHERE post_id = $post_id";
    $result = $db->query($query);
  }
}


?>
<main role="main">
<section class="panel important">
  <h2>Manage Posts:</h2>
  <?php
  //get all the posts
  $query = "SELECT posts.*, users.username, categories.name
            FROM posts, users, categories
            WHERE posts.user_id = users.user_id
            AND categories.category_id = posts.category_id";
  //if not an admin, only show the logged in users's posts
  if(! IS_ADMIN){
    $user_id = USER_ID;
    $query .= " AND posts.user_id = $user_id";
  }//end of ze if statement

  $query .= " ORDER BY posts.date DESC";

  $result = $db->query($query);
  if( $result->num_rows >= 1){
 ?>
 <form action ="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <table>
    <tr>
      <th>Title</th>
      <th>Date</th>
      <th>Author</th>
      <th>Status</th>
      <th>Category</th>
      <th><i class="fa fa-trash fa-2x"></i></th>
    </tr>

    <?php
    while($row = $result->fetch_assoc()){
    ?>
    <tr>
      <td><a href="admin_edit.php?post_id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a></td>
      <td><?php echo convert_timestamp($row['date']); ?></td>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['is_published'] == 1 ? 'Public' : '<b>Draft</b>'; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><input type="checkbox" name="delete[]" value="<?php echo $row['post_id'] ?>" /></td>
    </tr>
    <?php
    }//end of while loop
    ?>
  </table>
  <input type="submit" value="Delete Selected" />
  <input type="hidden" name="did_delete" value="1" />
</form>
<?php
}//end of if check it!
?>
</section>

</main>
<?php include('admin_footer.php'); ?>
