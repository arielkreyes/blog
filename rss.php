<?php
require('db_config.php');
include_once('functions.php');
//echo out the xml declaration since the <? characters confuse the PHP parser
echo '<?xml version="1.0" encoding="UTF-8"?>';
//get up to 10 most recent pg_connection_status
$query = "SELECT posts.title, posts.post_id, posts.date, users.email, users.username, posts.body
          FROM posts, users
          WHERE users.user_id = posts.user_id
          AND posts.is_published = 1
          ORDER BY posts.date DESC
          LIMIT 10";
//run it
$result = $db->query($query);
//check it
if(!$result){
  die($db->error);
}
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>My PHP blogginess</title>
    <link>https://localhost/reyesariel/blog/</link>
    <description>Practice RSS shindigs :)</description>
    <atom:link href="http://dallas.example.com/rss.xml" rel="self" type="application/rss+xml" />
    <?php while($row = $result->fetch_assoc()){ ?>
    <item>
      <title><?php echo $row['title']; ?></title>
      <link>https://localhost/reyesariel/blog/single.php?post_id=<?php echo $row['post_id']; ?></link>
      <guid>https://localhost/reyesariel/blog/single.php?post_id=<?php echo $row['post_id']; ?></guid>
      <pubDate><?php echo convert_timeRSS($row['date']); ?></pubDate>
      <author><?php echo $row['email']; ?> (<?php echo $row['username']; ?>)</author>
      <description><![CDATA[ <?php echo $row['body']; ?>]]></description>
    </item>
    <?php }//end of while loopy loop ?>
  </channel>
</rss>
