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


