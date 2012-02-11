<?php
	session_start();
	if(isset($_SESSION['id'])) 
	{
		$_SESSION = array();
		if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), '', time() - 3600);
		}
		session_destroy();
	}
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'index.php';
	header('location: ' . $home_url);
	?>