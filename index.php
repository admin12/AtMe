<?php
require_once('login.php');
if(!isset($_SESSION['id']))
{
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <title>At Me | Your Home On The Web</title>
	  <meta name="description" content="AtMe is your home on the Internet.  When you first sit down at your computer, you go to your AtME homepage and catch up with your Internet you">
	  <meta name="keywords" content="<?php echo $keywords; ?>">
	  <link rel="stylesheet" type="text/css" href="css/splash.css" />
	  <link rel="icon" href="favicon.gif" type"image/gif" />
	</head>
	<body>
	<?php 
	if($_GET['action'] == "register")
	{
		echo '<div class="splash1">';
		echo '<div class="register">';
		require_once('register.php');
	}
	else
	{
		echo '<div class="splash2">';
		echo '<div class="loginform">';
		echo '<p class="error">' . $error_msg .'</p>';  
	?>
		<p class="log"><a href="main.php">Click here to go to AtMe without logging in</a></p>
		<table>
		<tr>
		<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<td>Username </td><td><input type="text" id="username" name="username" class="login" /></td>
				</tr><tr>
				<td>Password </td><td><input type="password" id="password" name="password" class="login" /></td>
				</tr><tr>
				<td></td>
				<td><input type="hidden" name="url" value="main.php" /><input type="submit" value="Log In" name="login" class="submit" /></td>
		</form>
		</tr>			
		</table>
		<div class="register">
			<a href="index.php?action=register"><img src="images/register.png" border=0 /></a>
		</div>
		</div>
	<?php } ?>
	</div>
	</div>
	</body>
	</html>
<?php
}
else
{
	header('location: main.php');
}
?>