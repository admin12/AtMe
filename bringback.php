<?php
	session_start();
	require_once('constants.php');
	$usertable = USER_TABLE;
	$table = COMMENT_TABLE;
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$msgid = $_GET['msgid'];
	$userid = $_GET['userid'];
	$poster = $_GET['poster'];
	$pic = $_GET['pic'];
	if(($_SESSION['id'] == $poster) || ($_SESSION['id'] == $userid) || ($_SESSION['userlvl'] >= 2))
	{	
		$query = "UPDATE $table SET showmsg = '1' WHERE msgid = '$msgid' AND user_id = '$userid' LIMIT 1";
		mysqli_query($dbc, $query);
		
		$query2 = "SELECT id, username FROM $usertable WHERE id = '$userid'";
		$data = mysqli_query($dbc, $query2);
		
		$row = mysqli_fetch_array($data);
		//echo $row['id'] . $row['username'];
		if($pic == 0)
			header('Location: viewprofile.php?id=' . $row['id'] . '&user=' . $row['username']);
		else 
			header('location: photo.php?id='.$row['id'].'&user='.$row['username'].'&picid='.$pic.'&display=true
	}
	else
	{
		require_once('navigation.php');
		echo 'You must be logged in to delete messages';
	}
	
?>