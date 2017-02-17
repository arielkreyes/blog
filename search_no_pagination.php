<?php require('db_config.php');
//use _once on function definitions to prevent duplicates and breakin' yo shit.
      include_once('functions.php');
      include('header.php');

//extract and sanitize the keywords that the user is searching footer
$keywords = clean_string( $_GET['keywords']);
?>
    <main id="content">
      <?php
      //get all the published posts taht contain the keywords in their title or body
      $query = "SELECT DISTINCT *
                FROM posts
                WHERE is_published = 1
                AND (title LIKE '%$keywords%' OR body LIKE '%$keywords%' )";
      //run the query. Catch the returned info in a result object
      $result = $db->query($query);


      //check to see if the result has rows(posts) :D
      if( $result->num_rows >= 1 ){
        //loop through each row found, displaying the article each time
        while($row = $result->fetch_assoc()){
       ?>
       <article>
   			<h2>
   				<a href="single.php?post_id=<?php echo $row['post_id'] ?>">
   				<?php echo $row['title']; ?>
   				</a>
   			</h2>
   			<div class="post-info">
   				<?php echo convertTimestamp($row['date']); ?>
   			</div>

   			<p><?php echo $row['body']; ?></p>
   		</article>
    <?php
      }//end while there are posts
      else{
        echo 'Sorry, no posts to show.';
      }
    ?>
  <a href="blog.php">Read All Posts >></a>
  </main>
    <?php
    //get the aside
    include('sidebar.php');
    //get the footer and close the open body and html tags
    include('footer.php');
    ?>
