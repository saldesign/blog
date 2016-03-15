<section id="comment-form">
	<h2>Leave a comment:</h2>
	<?php 
	//parser feedback
	if(isset($message)){
		echo $message;
	}
	 ?>
	<form action="#comment-form" method="post">
		<label for="body">Comment:</label>
		<textarea name="body" id="body"></textarea>
		<input type="submit" value="Save Comment">
		<input type="hidden" name="did_comment" value="1">
	</form>
</section>