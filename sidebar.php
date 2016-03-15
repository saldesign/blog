<div class="container"><!-- Open .container -->
	<aside>
	<?php 
	//get titles of up to 5 latest published posts
	$query_latest = "SELECT posts.title, post_id
									FROM posts
									WHERE posts.is_published = 1
									ORDER BY posts.date DESC
									LIMIT 5";
	//run it
		$result_latest = $db->query($query_latest);

	//check to see if rows were found
		if($result_latest->num_rows >= 1){	?>
		<section>
			<h2>Latest Posts</h2>
			<ul>
			<?php	//loop it
			while( $row_latest = $result_latest->fetch_assoc() ){ ?>
				<li><a href="single.php?post_id=<?php echo $row_latest['post_id'] ?>"><?php echo $row_latest['title']; ?></a>
				(<?php count_comments($row_latest['post_id']); ?>)
				</li>
				<?php 
				}//end while 
				//free the result
				$result_latest->free();?>
			</ul>
		</section>
		<?php }//end if 

 	//get names of categories alphabetically orderd
	//get a count of the posts in each category	
	$query_latest = "SELECT categories.*, COUNT(*) AS total 
									FROM categories, posts
									WHERE categories.category_id = posts.category_id
									GROUP BY posts.category_id
									ORDER BY categories.name ASC";
	//run it
		$result_latest = $db->query($query_latest);

	//check to see if rows were found
		if($result_latest->num_rows >= 1){	?>
		<section>
			<h2>Categories</h2>
			<ul>
			<?php	//loop it
			while( $row_latest = $result_latest->fetch_assoc() ){ ?>
				<li><a href="#"><?php echo $row_latest['name'] ?></a>(<?php echo $row_latest['total']; ?>)</li>
				<?php 
				}//end while 
				//free the result
				$result_latest->free();?>
			</ul>
		</section>
		<?php }//end if 

 	//get titles of links randomly sorted
	$query_latest = "SELECT title, url 
									FROM links
									ORDER BY RAND()";
	//run it
		$result_latest = $db->query($query_latest);
	//check to see if rows were found
		if($result_latest->num_rows >= 1){	?>
		<section>
			<h2>Links</h2>
			<ul>
			<?php	//loop it
			while( $row_latest = $result_latest->fetch_assoc() ){ ?>
				<li><a href="<?php echo $row_latest['url'] ?>"><?php echo $row_latest['title'] ?></a></li>
				<?php 
				}//end while 
				//free the result
				$result_latest->free();?>
			</ul>
		</section>
		<?php }//end if ?>





	</aside>

