<?php 
	require('db-config.php'); //require will kill the page if it doesn't load successfully 
	include_once('functions.php');
	include('header.php');
	include('sidebar.php');
?>

	<main>
		<?php 
		//get 2 recently published posts
			$query = "SELECT posts.title, posts.body, posts.date, categories.name, users.username 
								FROM posts, categories, users
								WHERE posts.is_published = 1
								AND posts.category_id = categories.category_id
								AND users.user_id = posts.user_id
								ORDER BY posts.date DESC";
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
		<h2>My Blog:</h2>
			<?php while($row = $result->fetch_assoc() ){ ?>
			<article>
				<h3><?php echo $row['title']; ?></h3>				
				<div class="post-meta">
					<p>Author: <?php echo $row['username'] ?></p>
					<p>Posted on: <?php echo nice_date($row['date']);?></p>
					<p>Category:<?php echo $row['name'] ?></p></div>
				<p><?php echo $row['body']; ?></p>
			</article>
			<?php
				}//end while loop
			} //end if posts found
			else{
				echo 'No posts found';
			}//end if no posts found?> 
	</main>
</div><!-- Close .container -->

<?php 
	include('footer.php');
 ?>