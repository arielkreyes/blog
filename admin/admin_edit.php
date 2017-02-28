<?php
session_start();
require('../db_config.php');
include_once('../functions.php');

//header contains the security check, doctype, and <header> element
include('admin_header.php');
include('admin_nav.php');

//pre-fill the form with THIS post
//url looks like: admin_edit.php?post_id=5
$post_id = $_GET['post_id'];
$query = "SELECT * FROM posts
					WHERE post_id = $post_id
					LIMIT 1";
$result = $db->query($query);
if($result->num_rows == 1){
	$row 				 		= $result->fetch_assoc();

	$title 			 		= $row['title'];
	$body 			 		= $row['body'];
	$category_id 		= $row['category_id'];
	$allow_comments = $row['allow_comments'];
	$is_published 	= $row['is_published'];
}

//parse the form! :D
include('admin_write_parser.php');
?>
<main role="main">
	 <section class="panel important">
		 <h2>Edit Post</h2>
		 <?php show_feedback($feedback, $errors); ?>
		 <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>">
			 <div class="twothirds">
 			 <label>Title</label>
				<input type="text" name="title" value="<?php echo $title; ?>" />
				<label>Body</label>
				<textarea name="body"><?php echo $body; ?></textarea>
			 </div>
			 <div class="onethird">
				 <?php $query = "SELECT * FROM categories";
				 //run it
				 $result = $db->query($query);
				 //check it
				 if($result->num_rows >=1 ){ ?>
				 <label>Category</label>
				 <!-- Easy to remember: name after fields in the table! :D  -->
				 <select name="category_id">
					 <?php while($row = $result->fetch_assoc()){ ?>
					 <option value="<?php echo $row['category_id']; ?>" <?php select_it($category_id, $row['category_id']); ?>>
						<?php echo $row['name']; ?>
					 </option>
					 <?php }//end while ?>
				 </select>
				 <?php }//end of there are categories ?>
				 <label><input type="checkbox" name="is_published" value="1" <?php check_it($is_published, 1); ?>/>
					 Make this post public?</label>
				 <label><input type="checkbox" name="allow_comments" value="1" <?php check_it($allow_comments, 1); ?>/>
				 Allow people to comment on this post?</label>
				 <input type="submit" value="Save Post" />
				 <input type="hidden" name="did_post" value="1" />
			 </div>
	 </section>
	</main>

<?php include('admin_footer.php'); ?>
