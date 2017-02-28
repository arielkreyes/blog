<?php
//Warning: include(): Failed opening 'admin_write_parser' for inclusion (include_path='.;C:\xampp\php\PEAR') in C:\xampp\htdocs\reyesariel\blog\admin\admin_write.php on line 10

if($_POST['did_post']){
  //sanitize all fields
  $title = clean_string($_POST['title']);
  $body = clean_string($_POST['body']);
  $category_id = clean_integer($_POST['category_id']);
  $is_published = clean_boolean($_POST['is_published']);
  $allow_comments = clean_boolean($_POST['allow_comments']);
  //validate
  $valid= true;
    //title is blank
    if($title == ''){
      $valid = false;
      $errors['title'] = 'Title is required.';
    }
    //bodeee is blank
    if($body == ''){
      $valid = false;
      $errors['body'] = 'Post Body is required.';
    }
    //category cannot be blank or not a Number
    if($category_id == ''){
      $valid = false;
      $errors['category_id'] = 'Category is required.';
    }
    //if valid, add the post to the database
    if($valid){
      //convert the constant into a variable so we can use it in the query :)
      $user_id = USER_ID;
      $query = "UPDATE posts
                  SET
                  title          = '$title',
                  body           = '$body',
                  category_id    = $category_id,
                  is_published   = $is_published,
                  allow_comments = $allow_comments
                  WHERE post_id = $post_id";
      //run it
      $result = $db->query($query);
      //check it
      if( $db->affected_rows == 1 ){
        $feedback = 'Success! Your post was saved!';
      }//end of check it
      else{
        $fedback = 'No changes were made.';
      }
    }//end of one row added
    else{
      $feedback = 'Please fix the errors in the form.';
    }
    //show user feedback


}
//dont close php
