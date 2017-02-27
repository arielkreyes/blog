<?php
//conect to database
require('db_config.php');
//use _once on function definitions to prevent duplicates and breakin' yo shit.
include_once('functions.php');
include('header.php');
?>
    <main id="authors">
      <h2>Blog Authors</h2>
      <?php
      //get the links stuffs
      $query = "SELECT *
                FROM users";
      //run the query
      $result = $db->query($query);
      //check to see if the result has rows(posts) :D
      if( $result->num_rows >= 1 ){
        //loop through each row found, displaying the article each time
        while( $row = $result->fetch_assoc() ){
       ?>
      <article>
        <h3><a href="<?php echo $row['url']; ?>">
          <?php echo $row['title']; ?></a></h3>
        <p><?php echo $row['description']; ?></p>
      </article>
    <?php
      }//end while there are posts
     }//end of if there are posts statement O.O
      else{
        echo 'Sorry, authors to show. :(. ';
      }
    ?>
    </main>
    <?php
    //get the aside
    include('sidebar.php');
    //get the footer and close the open body and html tags
    include('footer.php');
    ?>
