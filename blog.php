<?php require('db_config.php');
//use _once on function definitions to prevent duplicates and breakin' yo shit.
      include_once('functions.php');
      include('header.php');
?>
    <main>
      <?php
      //get all the published posts, newest first
      $query = "SELECT posts.title, posts.date, posts.body, categories.name, users.username
                FROM posts, categories, users
                WHERE is_published = 1
                AND posts.category_id = categories.category_id
                AND posts.user_id = users.user_id
                ORDER BY date DESC
                LIMIT 20";
      //run the query
      $result = $db->query($query);
      //check to see if the result has rows(posts) :D
      if( $result->num_rows >= 1 ){
        //loop through each row found, displaying the article each time
        while( $row = $result->fetch_assoc() ){
       ?>
      <article>
        <h2><a href="single.php?post_id=<?php echo $row['post_id']; ?>">
          <?php echo $row['title']; ?></a></h2>
        <div class="postInfo">Written by <?php echo $row['username']; ?>
          Posted <?php echo convert_timestamp($row['date']); ?> in <?php echo $row['name']; ?></div>
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
