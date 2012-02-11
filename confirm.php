<?php
	session_start();
	$pagetitle = "Account Confirmation";
	require_once('navigation.php');
	$table = USER_TABLE;
	$username = $_GET['username'];
	$id = $_GET['id'];
	$referral = $_GET['referral'];
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$query = "UPDATE $table SET confirm = '1' WHERE username = '$username' AND id = '$id'";
	mysqli_query($dbc, $query);
	require_once('navigation.php');
	echo '<p class="register">Thanks, ' . $username . '.  You\'re account has now been confirmed. Enjoy your stay.</p>';
	require_once('footer.php');
?>