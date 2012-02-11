<?php
	session_start();
	require_once('constants.php');
	if(isset($_SESSION['id']))
	{
		$url = $_POST['url'];
		if((strlen($comment) <= 255) || (strlen($comment) > 0 ))
		{
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$posteduser = $_SESSION['id'];
			$comment = $_POST['comment'];
			$username = $_POST['username'];
			$userid = $_POST['wall'];
			$picid = $_POST['picid'];
			$usertable = USER_TABLE;
			$table = COMMENT_TABLE;
			$date = DATE('Y-m-d g:i:sa');
			$query = "INSERT INTO $table (pic_id, user_id, posteduser, date, comment) VALUES ('$picid', '$userid', '$posteduser', '$date', '$comment')";
			mysqli_query($dbc, $query);
			//echo $query;
			$query2 = "SELECT id, username FROM $usertable WHERE id = '$userid'";
			$data = mysqli_query($dbc, $query2);
			$row = mysqli_fetch_array($data);
			
			header('location: ' . $url);
			mysqli_close($dbc);
		}
		else
			echo 'Your message can be no more than 255 characters.';
	}
	else
	{
		echo '<p class="error">You must be logged in to leave a message.</p>';
	}
?>