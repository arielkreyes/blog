<nav role="navigation">
  <ul class="main">
    <li class="dashboard"><a href="index.php">Dashboard</a></li>
    <li class="write"><a href="admin_write.php">Write Post</a></li>
    <li class="edit"><a href="admin_manage.php">Edit Posts</a></li>

    <?php if( IS_ADMIN ){ ?>
    <li class="comments"><a href="admin_comments.php">Comments</a></li>
    <li class="users"><a href="admin_users.php">Manage Users</a></li>
    <?php } //end if is admin ?>
  </ul>
</nav>
