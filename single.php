<?php 
// Template for displaying single post with comments
// Link to this file like this:
// single.php?post_id=x
	$post_id = $_GET['post_id'];
	require('db-config.php'); //require will kill the page if it doesn't load successfully 
	include_once('functions.php');
	include('comment-parse.php');
	include('header.php');
	include('sidebar.php');
?>

	<main>
		<?php 
		//get 1 published posts that we are trying to view
			$query = "SELECT posts.title, posts.body, posts.date, categories.name, users.username, posts.allow_comments
								FROM posts, categories, users
								WHERE posts.is_published = 1
								AND posts.category_id = categories.category_id
								AND users.user_id = posts.user_id
								AND posts.post_id = $post_id
								ORDER BY posts.date DESC
								LIMIT 1";
		//run query
			$result = $db->query($query);
		//if the result is bad, show us the db error message
			if(!$result){
				die($db->error);
			}

		//check to see if more than post was found
			if($result->num_rows >= 1){

		
		//loop through posts found

		?>
		<h2>Latest Posts:</h2>
			<?php while($row = $result->fetch_assoc() ){
			//check if comments are allowed so we can use this var at the bottom of the page
			$comments_allowed = $row['allow_comments']; ?>
			<article>
				<h3><?php echo $row['title']; ?></h3>				
				<div class="post-meta">
					<p>Author: <?php echo $row['username']; ?></p>
					<p>Posted on: <?php echo nice_date($row['date']);?></p>
					<p>Category:<?php echo $row['name']; ?></p></div>
				<p><?php echo $row['body']; ?></p>
			</article>
			<?php
				}//end while loop
				$result->free();

				//get all approved comments written about this post
				$query = "SELECT users.username, comments.date, comments.body
									FROM users, comments
									WHERE comments.post_id = $post_id
									AND comments.is_approved = 1
									AND users.user_id = comments.user_id
									ORDER BY date DESC";

				// run it
				$result = $db->query($query);
				// check it 
				if(!$result){
					echo $db->error;
				}
				if( $result->num_rows >= 1){
				?>
				<h2>Comments</h2>
				<ul class="comment-list">
					<?php while( $row = $result->fetch_assoc() ){ ?>
					<li>
						<h3>Comment from <?php echo $row['username']; ?> 
						on <?php echo nice_date($row['date']); ?></h3>
						<p><?php echo $row['body'] ?></p>
					</li>
					<?php } // end while 
					$result->free() ?>
				</ul>

				<a href="blog.php">Blog</a>
			<?php 
				}//end if comments found
				else{
					echo '<h2>No comments found yet</h2>';
				}
				if( $comments_allowed ){
					include ('comment-form.php');
				}else{
					echo 'Comments are closed.';
				}//end if comments allowed
			} //end if posts found
			else{
				echo 'No posts found';
			}//end if no posts found?> 
	</main>
</div><!-- Close .container -->

<?php 
	include('footer.php');
 ?>