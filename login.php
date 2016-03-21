<?php 
session_start();
require('db-config.php');
include_once('functions.php');

//logout action
if($_GET['action'] == 'logout'){
	//TODO: remove the secret key from the DB

	//destroy the session, make all cookies null and expired
	session_destroy();

	unset($_SESSION['secretkey']);
	setcookie('secretkey', '', time() -999999);

	unset($_SESSION['user_id']);
	setcookie('user_id', '', time() -999999);
}//end logout action

//begin form parser
if($_POST['did_login']){
	//extract and sanitize
	$username = mysqli_real_escape_string($db, strip_tags($_POST['username']));
	$password = mysqli_real_escape_string($db, strip_tags($_POST['password']));
	//validate
	$valid = true;
	//username must be between 5-50 chars
	if(strlen($username) <= 5 AND strlen($username) >= 50 ){
		$valid = false;
	}
	//password must be at least 8 chars
	if(strlen($password) < 8){
		$valid = false;
	}
	//if valid, look them up in the db, then log them in
	//sha1 is our hash algorithm
	if($valid){
		$query = "SELECT user_id, is_admin
					 FROM users 
					 WHERE username = '$username'
					 AND password = sha1('$password')
					 LIMIT 1";
		$result = $db->query($query);
		if(!result){
			echo $db->error;
		}//end if no result
		//if 1 row is found, success, login for 1 week
		if($result->num_rows == 1){
			//success
			// hash(exact moment in time + random string)
			$secretkey = sha1(microtime() . 'hwhoad5641sfaju51yytththu5659iwdf');
			setcookie('secretkey', $secretkey, time()+60*60*24*7);
			$_SESSION['secretkey'] = $secretkey;

			//get the user id out of the result
			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];
			//store the user_id on their computer
			setcookie('user_id', $user_id, time()+60*60*24*7);
			$_SESSION['user_id'] = $user_id;
			//store the secretkey in the DB
			$query = "UPDATE users 
						SET secret_key = '$secretkey'
						WHERE user_id = $user_id
						LIMIT 1";
			$result = $db->query($query);
			if(!$result){
				die($db->error);
			}else{
				//redirect to admin panel 
				header('Location:admin/');
			}
		}else{
			//error
			$message = 'Your login info is incorrect, try again.';
		}//end num rows result
	}else{
			//invalid
			$message = 'Your login info is incorrect, try again.';
		}//end if valid
}//end parser
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log In to your account</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="login">

<header>
	<h1>Log In</h1>
</header>
<?php
	if(isset($message)){
		echo $message;
	}
?>
<main>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label>Username:</label>
		<input type="text" name="username">

		<label>Password:</label>	
		<input type="password" name="password">
		<input type="submit" value="Log In">
		<input type="hidden" name="did_login" value="1">
	</form>
</main>
</body>
</html>