<?php
//functions that are pretty damn useful. ^_^
function convert_timestamp($ugly){
  $date = new DateTime($ugly);
  //echo $date->format('l, F, jS, Y');
  //if echo was not present, it would not be spit out
  return $date->format('l, F, jS, Y');
}
//function to convert ugly timestamps for ze RSS :)
function convert_timeRSS($ugly){
  $date = new DateTime($ugly);
  //echo $date->format('l, F, jS, Y');
  //if echo was not present, it would not be spit out
  return $date->format('r');
}
//clean any inputstring
function clean_string($dirtydata){ //feed it in the field to dump it into the function itself :)
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_STRING));
}
function clean_integer($dirtydata){
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_NUMBER_INT));
}
function clean_email($dirtydata){
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_EMAIL));
}
function clean_url($dirtydata){
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_URL));
}
//zetting null checkboxes to 0
function clean_boolean($dirtydata){ //feed it in the field to dump it into the function itself :)
  if($dirtydata !=1){
    $dirtydata = 0;
  }
  return $dirtydata;
}
/**
 * helper function to output user feedback after parsing a form
 * @param string $feedback  A quick feedback message to the user
 * @param array $errors     A list of any inline field errors
 * @return string           Displays a div containing all the feedback and errors
 */
function show_feedback($feedback, $errors = array()){
  if( isset($feedback)){
    //^ if feedback exists (isset)
    echo '<div class="feedback">';
    echo $feedback;
    //if there are errors show them as a list
    if(! empty($errors)){
      echo '<ul>';
      foreach ($errors as $error) {
        echo '<li>' . $error . '</li>';
      }
      echo '</ul>';
    }
    echo '</div>';
  }
}
/**
 * helper function to make <slect> elements "sticky"
 * @param mixed $thing_one The first thing we are comparing
 * @param mixed $thing_two The second thing we're comparing
 * @return displays "selected" if they match
 */
function select_it($thing_one, $thing_two){
  if($thing_one == $thing_two){
    echo 'selected';
    }
  }
/**
 * helper function to make checkbox elements "sticky"
 * @param mixed $thing_one The first thing we are comparing
 * @param mixed $thing_two The second thing we're comparing
 * @return displays "checked" if they match
 */
function check_it($thing_one, $thing_two){
  if($thing_one == $thing_two){
    echo 'checked';
  }
}
/**
 * count the comments on any given posts
 * @param int $post_id any valid post id
 * @return string displays the number of comments, with comment/comments grammar
 */
function count_comments($post_id){
    global $db;
    $query = "SELECT COUNT(*) as total
              FROM comments
              WHERE post_id = $post_id";
    $result = $db->query($query);
    if( $result->num_rows == 1 ){
      $row = $result->fetch_assoc();
      $comments_number = $row['total'];
      if($comments_number == 1){
        echo 'One Comment';
      }elseif($comments_number == 0){
        echo 'No comments';
      }else{
        echo $comments_number . ' comments';
      }
    }//end of check it
}//end of count_comments function
/**
 * Count the number of posts written by any user
 * @param integer $user_id any valid user id
 * @param boolean $is_published 1 means True - count public posts(default)
 *                              0 means False - count drafts
 * @return int - displays the total number of posts :)
 */
function count_posts_by_user($user_id, $is_published = 1 ){
  global $db;
  $query = "SELECT COUNT(*) as total
            FROM posts
            WHERE user_id = $user_id
            AND is_published = $is_published";
  $result = $db->query($query);
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    echo $row['total'];
  }
}
/**
 * display an <img /> for any user's pic at any known size
 * @return [type] [description]
 */
function show_userpic($user_id, $size){
  global $db;
  $query = "SELECT userpic, username
            FROM users
            WHERE user_id = $user_id
            LIMIT 1";
  //run it
  $result = $db->query($query);
  if($result->num_rows == 1){
    //display the image if it exists,otherwise show the default userpic
    $row = $result->fetch_assoc();
    if($row['userpic'] != ''){
      echo '<img src="' . ROOT_URL . 'uploads/' . $row['userpic'] . '_' . $size . '.jpg" class="userpic" alt="' . $row['$username'] . '\'s user pic" />';
    }//end of if user has img
    else{
      echo '<img src="' . ROOT_URL . 'images/default' . $size . '.jpg"  class="userpic" alt="default userpic"/>';
    }
  }//end of if result num rows
}//end of function
