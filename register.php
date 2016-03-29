<?php 
session_start();
require('db-config.php');
include_once('functions.php');
//parse the form
if($_POST['did_register']){
	// sanitize
	$username = mysqli_real_escape_string($db,strip_tags($_POST['username']));
	$password = mysqli_real_escape_string($db,strip_tags($_POST['password']));
	$email = mysqli_real_escape_string($db,filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
	$policy = filter_var($_POST['policy'], FILTER_SANITIZE_NUMBER_INT);

	// validate
	$valid = true;
	// username is not within 5 - 50 chars
	if(strlen($username) < 5 OR strlen($username) > 50){
		$valid = false;
		$errors['username'] = 'Choose a username that is between 5 - 50 characters long';
	}else{
		// if it passed length check, check for username availability
		$query = "SELECT username 
						FROM users
						WHERE username = '$username'
						LIMIT 1";
		$result = $db->query($query);
		if(!$result){
			echo $db->error;
		}
		if($result->num_rows == 1){
			$valid = false;
			$errors['username'] = 'Sorry, that username is taken. Try another.';
		}
	}// end username tests
	// email is invalid
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address, ex: bobber@mail.com';
	}else{
		// email is invalid or blank
		$query = "SELECT email
					FROM users
					WHERE email = '$email'
					LIMIT 1";
		$result = $db->query($query);
		if(!$result){
			echo $db->error;
		}
		if($result->num_rows == 1){
			$valid = false;
			$errors['email'] = 'Your email address is already registered. Do you want to log in?';
		}
	}// end email tests
	// password too short
	if(strlen($password) < 8){
		$valid = false;
		$errors['password'] = 'Your password must be atleast 8 characters.';
	}
	// policy unchecked
	if($policy != 1){
		$valid = false;
		$errors['policy'] = 'You must agree to the terms of service';
	}
	// if valid, log them in and store user info in DB
	if($valid){
		//generate the secret key
		$secretkey = sha1(microtime() . 'a;dfgorighlkngoiuerohreho4938497856890jertyo');
		$query = "INSERT INTO users
						(username, password, email, date_joined, is_admin, secret_key)
						VALUES 
						('$username', sha1('$password'),'$email', now(), 0, '$secretkey')";
		$result = $db->query($query);
		//check to make sure 1 row was added
		if($db->affected_rows == 1){
			// success!
			//log them in automatically
			//get their user id
			$user_id = $db->insert_id;
			setcookie('user_id', $user_id, time()+60*60*24*7);
			$_SESSION['user_id'] = $user_id;

			setcookie('secretkey', $secretkey, time()+60*60*24*7);
			$_SESSION['secretkey'] = $secretkey;
			header('Location:admin/');
		}else{
			$message = 'Something went wrong during account creation, Sorry';
		}
	}// end if valid
}// end parser
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign up for an account</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic">
	<link rel="stylesheet" type="text/css" href="admin/admin.css">
</head>
<body class="login">
<h1>Sign up to comment</h1>
<?php //show user feedback
if($_POST['did_register']){
	echo '<div class="feedback">';
	if(isset($message)){
		echo $message;
	}
	//show errors as a list
	if(!empty($errors)){
		echo '<ul>';
		foreach($errors as $error){
			echo '<li>' . $error .'</li>';
		}
		echo '</ul>';
	}
	echo '</div>';
}
 ?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label <?php field_error($errors['username']) ?>>Create a Username</label>
			<input type="text" name="username" value="<?php echo $username ?>">
			<span class="hint">Between 5 - 50 Characters</span>
		<label>Your Email Address</label>
			<input type="email" name="email" placeholder="you@email.com" value="<?php echo $email ?>" <?php field_error($errors['email']) ?>>
		<label>Choose a password</label>
			<input type="password" name="password" value="<?php echo $password ?>" <?php field_error($errors['password']) ?>>
			<span class="hint">At least 8 Characters</span>

		<label <?php field_error($errors['policy']) ?>>
			<input type="checkbox" name="policy" value="1"  <?php echo $policy == 1 ? 'checked' : ''; ?>>
			I agree to the <a href="#">terms of service</a> and privacy policy
		</label>
		<input class="btn" type="submit" value="Submit">
		<input type="hidden" name="did_register" value="1">
</form>

</body>
</html>