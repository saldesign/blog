<?php 
require('../db-config.php'); //require will kill the page if it doesn't load successfully 
include_once(ROOT_PATH . '/functions.php');
require(ROOT_PATH . '/admin/admin-header.php');
include(ROOT_PATH . '/admin/admin-nav.php'); ?>


<main role="main">
  <section class="panel important">
    <h2>Manage Your Posts:</h2>
    <?php //get all posts written by logged in user
    $query = "SELECT posts.title, posts.is_published, posts.post_id, posts.date, categories.name
              FROM posts, categories
              WHERE posts.category_id = categories.category_id 
              AND posts.user_id = " . USER_ID . 
              " ORDER BY date DESC";
    $result = $db->query($query);
    if(! $result){
      echo $db->error;
    }
    if($result->num_rows >= 1){
     ?>
    <table>
      <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Date</th>
        <th>Category</th>
      </tr>
      <?php while($row = $result->fetch_assoc() ){ ?>
      <tr>
        <th><a href="admin-edit.php?post_id=<?php echo $row['post_id'];?>"><?php echo $row['title']; ?></a></th>
        <th><?php echo $row['is_published'] == 1 ? 'Public' : '<b>Draft<b>'; ?></th>
        <th><?php echo nice_date($row['date']); ?></th>
        <th><?php echo $row['name']; ?></th>
      </tr>
      <?php }//end while ?>
    </table>
    <?php }//end if rows found
    else{
      echo 'You haven\'t written any posts yet';
      } ?>

  </section>

</main>
<?php include(ROOT_PATH . '/admin/admin-footer.php') ?>