<?php
	session_start();
	require_once('constants.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>At Me | <?php echo $pagetitle; ?></title>
  <meta name="description" content="AtMe is your home on the Internet.  When you first sit down at your computer, you go to your AtME homepage and catch up with your Internet you">
  <meta name="keywords" content="<?php echo $keywords; ?>">
  <link rel="stylesheet" type="text/css" href="css/layout.css" />
  <link rel="stylesheet" type="text/css" href="css/navigation.css" />
  <link rel="stylesheet" type="text/css" href="css/content.css" />
  <link rel="stylesheet" type="text/css" href="css/comments.css" />
  <link rel="stylesheet" type="text/css" href="css/footer.css" />
  <link rel="stylesheet" type="text/css" href="css/profile.css" />
  <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
  <link rel="icon" href="favicon.gif" type="image/gif" />
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <script type="text/javascript">
  
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-18169622-1']);
    _gaq.push(['_trackPageview']);
  
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  
  </script>
  <script type="text/javascript">
   function clearMe(formfield){
    if (formfield.defaultValue==formfield.value)
     formfield.value = ""
   }
  </script>
  <script type="text/javascript" src="js/prototype.js"></script>
  <script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
  <script type="text/javascript" src="js/lightbox.js"></script>
  <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
</head>
<body>
<div id="page-container">
	<div id="nav">
		<div id="logo"><a href="main.php"><img src="images/logo.png" border=0 alt="AtMe!" width=183 height=78></a>
		</div>

		<span class="navlinks">
			<table cellpadding="0" cellspacing="0">
			<tr>
			<td><a href="index.php"><img alt="Off alternate text" src="images/home.jpg"
			onmouseover="this.src='images/homeOver.jpg';this.alt='On alternate text';"
			onmouseout="this.src='images/home.jpg';this.alt='Off alternate text';" border=0 /></a></td>
			<td><a href="viewprofile.php"><img alt="Off alternate text" src="images/view.png"
			onmouseover="this.src='images/viewOver.png';this.alt='On alternate text';"
			onmouseout="this.src='images/view.png';this.alt='Off alternate text';" border=0 /></a></td>
			<?php if(isset($_SESSION['id'])) 
			{ ?>
			<td><a href="editprofile.php"><img alt="Off alternate text" src="images/edit.png"
			onmouseover="this.src='images/editOver.png';this.alt='On alternate text';"
			onmouseout="this.src='images/edit.png';this.alt='Off alternate text';" border=0 /></a></td>
			<td><a href="settings.php"><img alt="Off alternate text" src="images/account.png"
			onmouseover="this.src='images/accountOver.png';this.alt='On alternate text';"
			onmouseout="this.src='images/account.png';this.alt='Off alternate text';" border=0 /></a></td>
			<?php if($_SESSION['userlvl'] == 3) 
			{ ?>
				<td><a href="admin.php"><img alt="Off alternate text" src="images/admin.jpg"
				onmouseover="this.src='images/adminOver.jpg';this.alt='On alternate text';"
				onmouseout="this.src='images/admin.jpg';this.alt='Off alternate text';" border=0 /></a></td>
			<?php } ?>
			<td><a href="logout.php"><img alt="Off alternate text" src="images/logout.png"
			onmouseover="this.src='images/logoutOver.jpg';this.alt='On alternate text';"
			onmouseout="this.src='images/logout.png';this.alt='Off alternate text';" border=0 /></a></td>
			<?php } ?>
			<td>
			<div id="searchwrapper"><form method="get" action="search.php" value="User Search">
			<input type="text" class="searchbox" name="search" value="Search..." onfocus="clearMe(this)" />
			<input type="image" src="images/searchbutton.png" class="searchbox_submit" value="" />
			</form>
			</div>
			</td>
			</tr>
			</table>
		</span>
	</div>
	<div id="content">
	<?php $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); ?>