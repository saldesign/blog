<?php 
require('../db-config.php'); //require will kill the page if it doesn't load successfully 
include_once(ROOT_PATH . '/functions.php');
require(ROOT_PATH . '/admin/admin-header.php');
include(ROOT_PATH . '/admin/admin-nav.php');

//parse the form
if($_POST['did_post']){
  //extract and sanitize
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $body = mysqli_real_escape_string($db, $_POST['body']);
  $is_published = mysqli_real_escape_string($db, $_POST['is_published']);
  $allow_comments = mysqli_real_escape_string($db, $_POST['allow_comments']);
  $category_id = mysqli_real_escape_string($db, $_POST['category_id']);
  //validate
  $valid = true;
  //title and body can't be blank
  if($title == '' OR $body == ''){
    $valid = false;
    $errors[]= 'Title and body are required';
  }
  //checkboxes must be 1 or 0 (not blank)
  if($is_published != 1){
    $is_published = 0;
  }
  if($allow_comments !=1){
    $allow_comments = 0;
  }
  //category must be int
  if(! is_numeric( $category_id)){
    $valid = false;
    $errors[] = 'Please choose a valid category';
  }
  //if valid, add to DB
  if($valid){
    $query = "INSERT INTO posts
              ( title, date, body, user_id, category_id, is_published, allow_comments)
              VALUES
              ('$title', now(), '$body', " . USER_ID . ", $category_id, $is_published,$allow_comments ) ";
    $result = $db->query($query);
    if(! $result){
      echo $db->error;
    }
    //make sure 1 row was added, show user feedback
    if($db->affected_rows == 1){
      $message = 'Your post was saved';
    }else{
      $message = 'Sorry, Your post was not saved';
    }
  }//end if valid
  else{
    $message = 'Please check for the following errors:';
  }
}//end of parser
 ?>



<main role="main">
  <section class="important panel">
    <h2>Write New Post</h2>
    <?php //show feedback if form was submitted
    if($_POST['did_post']){
      echo '<div class="feedback">';
      echo $message;
      //if there are little errors, show them in a list
      if(! empty($errors)){
        echo '<ul>';
          foreach($errors as $item){
            echo '<li>' . $item . '</li>';
          }
        echo '</ul>';
      }
      echo '</div>';
    }

     ?>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="twothirds">
        <label>Title</label>
        <input type="text" name="title" value="<?php echo stripslashes($title); ?>">

        <label>Body:</label>
        <textarea name="body"><?php echo stripslashes($body); ?></textarea>
      </div>
      <div class="onethird">
        <label>
          <input type="checkbox" name="is_published" value="1" <?php checked( $is_published, 1) ?>>
          Make this post public
        </label>

        <label>
          <input type="checkbox" name="allow_comments" value="1" <?php checked( $allow_comments, 1) ?>>
          Allow users to comment on this post
        </label>

      <?php // get all the categories in alphabetical order
      $query ="SELECT * FROM categories 
      ORDER BY name ASC";
      $result = $db->query($query);
      if(! $result){
        echo $db->error;
      }
      if($result->num_rows >= 1){ ?>
      <label>Category:</label>
      <select name="category_id">
        <?php while($row = $result->fetch_assoc() ){ ?>
        
        <option value="<?php echo $row['category_id']; ?>" <?php 
        selected($category_id, $row['category_id']); ?>>
        <?php echo $row['name']; ?>
        </option>

        <?php }// end whilde ?>
      </select>
      <?php }// end if categories ?>
      <input type="submit" value="Save Post">
      <input type="hidden" name="did_post" value="1">
    </div>
  </form>
</section>
</main>
<?php include(ROOT_PATH . '/admin/admin-footer.php') ?>