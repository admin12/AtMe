<?php
	session_start();
	require_once('constants.php');
	$pagetitle = 'Registration';
	$keywords = '@me, atme, register, signup, homepage, users, social, web homepage, internet homepage';
	$table = USER_TABLE;
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if (isset($_POST['submit'])) 
	{
		$fname = ucwords(mysqli_real_escape_string($dbc, trim($_POST['fname'])));
		$lname = ucwords(mysqli_real_escape_string($dbc, trim($_POST['lname'])));
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$year = mysqli_real_escape_string($dbc, trim($_POST['year']));
		$month = mysqli_real_escape_string($dbc, trim($_POST['month']));
		$day = mysqli_real_escape_string($dbc, trim($_POST['day']));
		$birthdate = $year . "-" . $month . "-" . $day;
		$birthpub = mysqli_real_escape_string($dbc, trim($_POST['birthpub']));
		$msg = "";
		$pwmsg = "";
	    $error = false;
		
		if(!empty($fname) && !empty($lname) && !empty($year) && !empty($month) && !empty($day) && !empty($username) && !empty($password1) && !empty($password2) && !empty($email) && ($password1 == $password2)) 
		{
			$query = "SELECT * FROM $table WHERE username = '$username'";
			$data = mysqli_query($dbc, $query);
			
			if (mysqli_num_rows($data) == 0) 
			{
				if (strlen($password1) >= 6)
				{
					$name = $fname . " " . $lname;
					$query = "INSERT INTO $table (confirm, date, birthdate, birthpub, name, username, password, email, picture) VALUES ('0', NOW(), '$birthdate', '$birthpub', '$name', '$username', SHA('$password1'), '$email', 'nopic.jpg')";
					mysqli_query($dbc, $query);	
	
					$id_query = "SELECT id, email, username FROM $table WHERE username = '$username'";
				    $search = mysqli_query($dbc, $id_query);
				    $rows = mysqli_fetch_array($search);
				    $id = $rows['id'];
				    $email = $rows['email']; 
				    $subject = "Please Confirm Your Account"; 
	
				    $message = "Hello, $name. Thank you for creating an @ME account. <br /> To confirm your account, <a href='http://itsatme.com/confirm.php?username=$username&id=$id'>Click Here</a>"; 
				    mail($email, $subject, $message, 'From: mrmann14@gmail.com');
				    //$error_msg =  'Thank you for the request. We will let you know in the next few days if you have been accepted.';
				}
				else
					$error_msg = 'Your password must be at least 6 characters long.';
			}
			else 
			{
				$error_msg = "Please ensure that your username and email address are unique.";
				$username = "";
			}
		}
		else 
		{
			if(empty($fname) || empty($lname) || empty($username) || empty($password1) || empty($password2) || empty($email) || empty($year) || empty($month) || empty($day)) 
			{
				$error_msg = "Please ensure that all fields have been completed. ";
			}
			if($password1 != $password2)
			{
				$pwmsg = "Please ensure that the passwords match.";
			}
		}
	}

echo '<h3>Request Invite</h3>';
echo '<div align="center">' . $message . '</div>';
echo '<div class="error">' . $error_msg . '</div><div class="error">'.$pwmsg.'</div>';
if (!isset($message)) 
{
?> 

<form enctype="multipart/form-data" method="post" action="index.php?action=register">
    <input type="hidden" name="MAX_FILE_SIZE" value="MM_MAXFILESIZE" />
	<table>
	<tr height="50">
		<td>
		First Name
		</td>
		<td>
			<input type="text" id="fname" name="fname" class="login" value="<?php if (!empty($fname)) echo $fname; ?>" />
		</td>
	</tr>
	<tr height="50">
		<td>
    	Last Name 
    	</td>
    	<td>
    		<input type="text" id="lname" name="lname" class="login" value="<?php if (!empty($lname)) echo $lname; ?>" />
		</td>
	</tr>
	<tr height="50">
		<td>
    	Birthdate
   		</td>
   		<td>
	    	<select name="year">
	    		<?php require_once('year.php'); ?>
	    	</select>
	    	<select name="month">
	    		<?php require_once('month.php'); ?>
	    	</select>
	    	<select name="day">
	    		<?php require_once('day.php'); ?>
	    	</select>
		</td>
	</tr>
	<tr height="50">
		<td>
    	Public Birthdate?<br /><span class="subtext">Show your birthdate in profile</span>
    	</td>
    	<td>
	    	<input type="radio" name="birthpub" value="1" />Yes
	    	<input type="radio" name="birthpub" value="0" />No
    	</td>
    </tr>
    <tr height="50">
    	<td>
    	Username
    	</td>
    	<td>
    		<input type="text" id="username" name="username" class="login" value="<?php if (!empty($username)) echo $username; ?>"/>
		</td>
	</tr>
	<tr height="50">
		<td>
		Password <br /><span class="subtext">At least 6 characters.</span>
		</td>
		<td>
    		<input type="password" id="password1" name="password1"class="login" />
		</td>
	</tr>
	<tr height="50">
		<td>
			Verify Password<br /><span class="subtext">Please ensure that they match</span>
		</td>
		<td>
    		<input type="password" id="password2" name="password2" class="login" />
		</td>
	</tr>
	<tr height="50">
		<td>
		Email Address <br /> <span class="subtext">(user@domain.com)</span>
		</td>
		<td>
    		<input type="text" id="email" name="email" class="login" value="<?php if (!empty($email)) echo $email; ?>" />
    	</td>
    </tr>
    <tr>
    	<td>
    		<input type="submit" value="Request" name="submit" class="submit" />
    	</td>
    </tr>
    </table>
    <br /> 	 
 </form>
 <?php 
 }
 ?>