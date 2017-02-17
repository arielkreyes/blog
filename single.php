<?php require('db_config.php');
//use _once on function definitions to prevent duplicates and breakin' yo shit.
      include_once('functions.php');
      //get the doctype and header area
      include('header.php');

      if(isset($_GET['post_id']) ){
        $post_id = $_GET['post_id'];
      }else{
        $post_id = 0;
      }
      // FORM PARSING of ze comments
      if($_POST['did_comment'] ){
        //extract the values that the user typed in and sanitize it!@
        $name = clean_string($_POST['name']);
        $email = clean_email($_POST['email']);
        $url = clean_url($_POST['url']);
        $body = clean_string($_POST['body']);
        //validate!
        $valid = true;
        //if name is blank
        if($name == ''){
          $valid = false;
          $errors['name'] = 'Name field is required.';
        }

        if( ! filter_var($email, FILTER_VALIDATE_EMAIL)){
          $valid = false;
          $errors['email'] = 'A valid email is required.';
        }
        //body of comment cant be blank
        if( $body == ''){
          $valid = false;
          $errors['body'] = 'Comment body is required.';
        }
        //if valid, add to database
        if( $valid ){
        //add one comment to the db
        $query = "INSERT INTO comments
                    (name, date, body, post_id, email, url, is_approved)
                    VALUES
                    -- '' or no '' depends on the datatype that was established in the table construction ie VARCHAR INT etc.
                    ( '$name', now(), '$body', $post_id, '$email', '$url', 1 )";
        //run it
        $result = $db->query($query);
        //check it
        if( $db->affected_rows == 1){
          $status = 'success';
          $message = 'Thanks for commenting on my blog. :)';
        }else{
          $status = 'error';
          $message = 'Database Error';
        }//end of if row added
      }else{
          $status = 'error';
          $message = 'Invalid Submission';
      }


        //user feedback
      }//end of parser shindigs
?>
    <main>
      <?php
      //get the most recent 2 published posts
      $query = "SELECT posts.title, posts.body, users.username, posts.date
                FROM posts, users
                WHERE posts.user_id = users.user_id
                AND posts.is_published = 1
                AND posts.post_id = $post_id
                LIMIT 1";
      //run the query
      $result = $db->query($query);
      //check to see if the result has rows(posts) :D
      if( $result->num_rows >= 1 ){
        //loop through each row found, displaying the article each time
        while($row = $result->fetch_assoc() ){
       ?>
      <article>
        <h2><?php echo $row['title']; ?></h2>
        <p><?php echo $row['body']; ?></p>
        <div class="postInfo">
            By <?php echo $row['username']; ?>
            on <?php echo convert_timestamp($row['date']); ?>
        </div>
      </article>
      <?php
      }//end while there are posts  ?>
      <?php
      //get all the approved comments about THIS posts
      $query = "SELECT body, name, url, date
                FROM comments
                WHERE is_approved = 1
                AND post_id = $post_id
                ORDER BY date ASC
                LIMIT 20 ";
      //run it
      $result = $db->query($query);
      //check if we found any comments
      if( $result->num_rows >= 1 ){
      ?>
      <section class="comments">
        <h3>Comments on this post:</h3>
      <?php while($row = $result->fetch_assoc() ){?>
        <div class="oneComment">
          <div class="commentBody">
            <?php echo $row['body']; ?>
          </div>
          <div class="commentInfo">
            From <a href="<?php echo $row['url']; ?>"><?php echo $row['name']; ?></a>
            on <?php echo convert_timestamp($row['date']); ?>
          </div>
        </div>
      <?php }//end of while loop ?>
      </section>
      <?php
      }//end of if there are comments
      else{
        echo 'Nobody has commented yet!';
      }
       ?>
      <section class="addComment" id="comment_Form">
        <h3>Add a Comment</h3>
        <?php //user feedback
        echo $message;
        ?>
        <form action="#comment_Form" method="post">

          <label for="theName">Name</label>
          <input type="text" name="name" id="theName" />

          <label for="theEmail">Email</label>
          <input type="email" name="email" id="theEmail" />

          <label for="theUrl">url (optional)</label>
          <input type="url" name="url" id="theUrl" />

          <label for="theBody">Comment:</label>
          <textarea name="body" id="theBody"></textarea>

          <input type="submit" value="Leave Comment" />
          <input type="hidden" name="did_comment" value="true" />

        </form>
      </section>
    <?php

     }//end of if there are posts statement O.O

    ?>
  </main>
    <?php
    //get the aside
    include('sidebar.php');
    //get the footer and close the open body and html tags
    include('footer.php');
    ?>
