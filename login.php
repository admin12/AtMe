<?php
	session_start();
	require_once('constants.php');
	$table = USER_TABLE;
	$error_msg = "";
	if(empty($_SESSION['id']))
	{
		if (isset($_POST['login']))
		{
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
			$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
			$url = mysqli_real_escape_string($dbc, trim($_POST['url']));
			if(!empty($user_username) && !empty($user_password)) 
			{
				$query = "SELECT id, userlvl, confirm, username FROM $table WHERE username = '$user_username' AND password = SHA('$user_password')";
				$data = mysqli_query($dbc, $query);
				
				if(mysqli_num_rows($data) == 1) 
				{
					$row = mysqli_fetch_array($data);
					if($row['confirm'] == 1)
					{
						$_SESSION['id'] = $row['id'];
						$_SESSION['userlvl'] = $row['userlvl'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['password'] = $row['password'];
						$_SESSION['veripass'] = SHA1($user_password);
						header('location: ' . $url);
					}
					else
					{
						$error_msg = 'Please ensure that you have confirmed  your account.';
					}
				}
				else
				{
					$error_msg = 'Sorry, you must enter a valid username and password to log in.';
				}
			}
			else
			{
				$error_msg = 'Sorry, you must enter your username and password to log in.';
			}
			mysqli_close($dbc);
		}
	}
	?>