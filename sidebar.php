
<aside>
  <section>
    <h2>Recent Posts</h2>
    <?php
    //get the 5 latest published post titles
    //TODO: make this show the posts that have 0 comments
    $query = "SELECT posts.title, COUNT(*) AS total, posts.post_id
              FROM posts, comments
              WHERE posts.post_id = comments.post_id
              AND posts.is_published = 1
              ORDER BY posts.date DESC
              LIMIT 5";
    //run it
    $result = $db->query($query);
    //check it
    if($result->num_rows >= 1 ){ ?>
    <ul>
      <?php
      //loop it
      while( $row = $result->fetch_assoc()){ ?>
      <li><a href="single.php?post_id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a> - <?php echo $row['total']; ?> comments</li>
      <?php }//end of while Loop
      //free after SELECT
      $result->free();
      ?>
    </ul>
    <?php }//end of if statement
    else {
      echo 'No posts to show.';
    } ?>
  </section>
  <section>
    <h2>Categories</h2>
    <?php //get all category names in alphabetical order
    $query = "SELECT cat.name, COUNT(*) AS total
              FROM categories AS cat, posts
              WHERE cat.category_id = posts.category_id
              GROUP BY posts.category_id
              ORDER BY cat.name ASC
              LIMIT 5";
    //run it
    $result = $db->query($query);
    //check it
    if($result->num_rows >=1){?>
    <ul>
      <?php
      //loop it
      while( $row = $result->fetch_assoc()){ ?>
      <li><?php echo $row['name']; ?> (<?php echo $row['total']; ?>)</li>
      <?php }//end of while
      //free after SELECT
      $result->free();
      ?>
    </ul>
    <?php }//end of if statement
    else {
      echo 'No categories to show.';
    } ?>
  </section>
  <section>
    <h2>Links</h2>
    <?php //get all links alphabetical by title
    $query = "SELECT title, url
              FROM links
              ORDER BY title ASC";
    //run it
    $result = $db->query($query);
    //check it
    if($result->num_rows >=1){ ?>
    <ul>
      <?php
      //loop it
      while( $row = $result->fetch_assoc()){ ?>
      <li><a href="<?php echo $row['url'];?>"><?php echo $row['title'];?></a></li>
      <?php }//end of while loop
      //free after SELECT
      $result->free();
      ?>
    </ul>
    <?php }//end of if statement
    else {
      echo 'No Links to Show. :(';
    } ?>
  </section>
</aside>
