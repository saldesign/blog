<?php 
	//convert datetime format to nice looking date
	function nice_date( $datetime ){
		$date = new DateTime( $datetime );
		return $date->format('l,  F j');
	}


//convert datetime format to RFC 822 format for the feed
function rss_date( $datetime ){
	$date = new DateTime( $datetime );
	return $date->format( 'r' );
}

//count the comments on any one post
//$post_id = INT the post you are counting comments for
function count_comments( $post_id ){
	global $db;
	//count the approved comments on post #2
	$query = "SELECT COUNT(*) AS total
						FROM comments
						WHERE post_id = $post_id
						AND is_approved = 1";
	//run it
	$result = $db->query($query);
	//check it
	if( $result->num_rows >= 1 ){
		//loop it
		while( $row = $result->fetch_assoc() ){
			echo $row['total'];
		}
		//free it
		$result->free();
	}//end if
}//end count_comments() 

//Use for hilighting form fields with an error
function field_error($problem){
	if(isset($problem)){
		echo 'class="error"';
	}
}

//count the number of posts that any user has
//@param $user_id = int. the ID of any user
//@param $is_published = BOOLEAN. 1 = published posts (default)
//											0 = drafts
//@return int. the total number of posts
function count_posts( $user_id, $is_published = 1){
	global $db;
	$query = "SELECT COUNT(*) AS total
				FROM posts 
				WHERE user_id = $user_id
				AND is_published = $is_published";
	$result = $db->query($query);
	// count will return one value / row
	if(! $result){
		echo $db->error;
	}
	$row = $result->fetch_assoc();
	return $row['total'];
}

/**
 * Show the post written by any user with the most comments
 * @param $user_id int.  Any user id.
 * @return string. the title and number of comments on that post
 * @author Christian
 * @see https://www.phpdoc.org/
 */
function most_popular_post( $user_id){
	global $db;
	$query = "SELECT COUNT(*) AS total, posts.title
					FROM comments, posts
					WHERE comments.post_id = posts.post_id
					AND posts.user_id = $user_id
					GROUP BY posts.post_id
					ORDER BY total DESC
					LIMIT 1";
	$result = $db->query($query);
	if(! $result){
		echo $db->error;
	}
	if($result->num_rows == 1){
		//popular posts found! return the title of the post
		$row = $result->fetch_assoc()
;		return $row['title'] . '(' . $row['total'] . ')';
	}else{
		return 'Your posts do not have any comments yet.';
	}
}

/**
	*Helper for checking a checkbox if two values match
*/
function checked($thing1, $thing2){
	if($thing1 == $thing2){
		echo 'checked';
	}
}
/**
	*Helper for selecting an option in a dropdown if two values match
*/
function selected($thing1, $thing2){
	if($thing1 == $thing2){
		echo 'selected';
	}
}
