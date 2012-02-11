<?php
	session_start();
	require_once('constants.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>At Me | Your Home On The Web</title>
  <meta name="description" content="AtMe is your home on the Internet.  When you first sit down at your computer, you go to your AtME homepage and catch up with your Internet you">
  <meta name="keywords" content="<?php echo $keywords; ?>">
  <link rel="stylesheet" type="text/css" href="css/main.css" />
  <link rel="icon" href="favicon.gif" type"image/gif" />
</head>
<body>
<div id="page-container">
	<div id="nav">
		<div id="logo"><img src="images/logo.png" border=0 alt="AtMe!" width=183 height=78>
		</div>

		<span class="navlinks">
			<table cellpadding="0" cellspacing="0">
			<tr>
			<td><a href="index.php"><img src="images/home.gif" border=0 height=52 alt="Home" /></a></td>
			<td><a href="viewprofile.php"><img src="images/view.gif" border=0 height=52 alt="View Profile" /></a></td>
			<td><a href="editprofile.php"><img src="images/edit.gif" border=0 height=52 alt="Edit Profile" /></a></td>
			<td><a href="settings.php"><img src="images/account.gif" border=0 height=52 alt="Account" /></a></td>
			<td><a href="logout.php"><img src="images/logout.jpg" border=0 height=52 alt="Logout" /></a></td>
			<td>
			<div id="searchwrapper"><form method="get" action="search.php" value="User Search">
			<input type="text" class="searchbox" name="search" value="" />
			<input type="image" src="images/searchbutton.png" class="searchbox_submit" value="" />
			</form>
			</div>
			</td>
			</tr>
			</table>
		</span>
	</div>
	<div id="content">