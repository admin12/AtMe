<?php
	session_start();
	require_once('constants.php');
	$pagetitle = 'Registration';
	$keywords = '@me, atme, register, signup, homepage, users, social, web homepage, internet homepage';
	$table = USER_TABLE;
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		$fname = ucwords(mysqli_real_escape_string($dbc, trim($_POST['fname'])));
		$lname = ucwords(mysqli_real_escape_string($dbc, trim($_POST['lname'])));
		$msg = "";
		$pwmsg = "";
	    $error = false;
		
			$query = "INSERT INTO names (fname, lname) VALUES ('$fname', '$lname')"; 
			mysqli_query($dbc, $query);
?>
			