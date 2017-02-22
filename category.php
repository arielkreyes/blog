<?php
error_reporting( E_ALL & ~E_NOTICE );
//conect to database
require('db_config.php');
//use _once on function definitions to prevent duplicates and breakin' yo shit.
include_once('functions.php');
include('header.php');
//get the title of the category clicked!
      $query = "SELECT *
                FROM categories";

      if(isset($_GET['category_id'])){
        $category_id = $_GET['category_id'];
      }
?>
    <main id="category">
      <?php
      //get all the posts within that category
      $query = "SELECT posts.title, posts.date, posts.body, categories.category_id, categories.name, posts.post_id
                FROM posts, categories
                WHERE posts.category_id = categories.category_id
                AND posts.is_published = 1
                AND categories.category_id = $category_id
                ORDER BY date DESC
                LIMIT 5";
      //run the query
      $result = $db->query($query);

      //check to see if the result has rows(posts) :D
      if( $result->num_rows >= 1 ){
      ?>

      <h2>Posted in CATEGORYNAME</h2>
      <?php
        //loop through each row found, displaying the article each time
        while( $row = $result->fetch_assoc() ){
      ?>

      <article>
        <h3><a href="single.php?post_id=<?php echo $row['post_id']; ?>">
          <?php echo $row['title']; ?></a></h3>
        <p><?php echo $row['body']; ?></p>
      </article>
    <?php
      }//end while there are posts
     }//end of if there are posts statement O.O
      else{
        echo 'Sorry, no posts to show. :(. ';
      }
    ?>
    </main>
    <?php
    //get the aside
    include('sidebar.php');
    //get the footer and close the open body and html tags
    include('footer.php');
    ?>
