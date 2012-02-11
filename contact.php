<?php
	session_start();
	$pagetitle = "Contact Us";
	$keywords = '@me, atme, contact, us, users, social, web homepage, internet homepage';
	require_once('navigation.php');
	echo '<h3>Contact Us</h3>';

	if (isset($_POST['email'])) 
	{
		$from = $_POST['from'];
		$name = $_POST['name'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		if(!empty($from) && !empty($name) && !empty($subject) && !empty($message))
		{
			mail('mrmann14@gmail.com', $subject, $message, "From: $from");
			echo '<p class="register">Your email has been sent.  You will receive a reply in the next 1-2 business days. We appreciate your input. You will be redirected back to the homepage.</p>';
			header('refresh: 3; url=index.php');
		}
		else
		{
			echo '<p class="error">Please ensure that all information has been properly filled out.</p>';
		}
		
	}
?>
<form  enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<table class="register">
	<tr heigh="30"><td>Name</td><td>
    <input type="text" id="name" class="contbox" name="name" size="69" value="<?php if (!empty($name)) echo $name; ?>" /><br />
    </td></tr>
    <tr height="30"><td>Email</td><td>
    <input type="text" id="from" class="contbox" name="from" size="69" value="<?php if (!empty($from)) echo $from; ?>" /><br />
	</td></tr>
	<tr height="30"><td>Subject</td><td>
    <input type="text" id="subject" class="contbox" name="subject" size="69" value="<?php if (!empty($subject)) echo $subject; ?>" /><br />
	  </td></tr>
	  <tr height="30"><td valign="top">Message</td><td>
    <textarea name="message" id="message" class="contbox" rows="10" cols="50"></textarea><br />
    </td></tr><tr><td><input type="submit" value="Send" name="email" /></td></tr>
    </table>
 </form>
<?php 
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	require_once('footer.php');
?>