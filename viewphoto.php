<?php
session_start();

$userid = $_GET['id'];
$picid = $_GET['picid'];
$username = $_GET['user'];
$display = $_GET['display'];

$pagetitle = 'Photo of ' . $username;
$keywords = '@me, atme, homepage, users, social, web homepage, internet homepage';
require_once('navigation.php');
require_once('msgsys.php');

$pictable = PIC_TABLE;
$usertable = USER_TABLE;
	
	if($display == "false")
	{
		$query = "SELECT date, path FROM $pictable WHERE picid = '$picid'";
		$row = mysqli_fetch_array(mysqli_query($dbc, $query));
		echo '<h3>Photo - '.$username.'</h3><span class="commentdate"> '.$row['date'].'</span>';
		$path = $row['path'];
	}
	else
	{
		$query = "SELECT picture FROM $usertable WHERE id = '$userid'";
		$row = mysqli_fetch_array(mysqli_query($dbc, $query));
		echo '<h3> Disply Picture - '.$username.'</h3>';
		$path = $row['picture'];
	}
	echo '<div class="moveTable">';
	echo '<br /><img src="images/' . $path . '" />';
	echo '<br /><span class="imgDescription">'.$row['description'].'</span>';
	echo comment($dbc, $userid, $picid);
    
	echo '</div>';
	require_once('footer.php');

?>