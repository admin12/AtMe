<?php
	session_start();
	$pagetitle = 'Account Setting - ' . $_SESSION['username'];
	$keywords = '@me, atme, account, settings, homepage, users, social, web homepage, internet homepage' . $user;
  	require_once('navigation.php');
  	$table = USER_TABLE;
	if(isset($_SESSION['id']))
	{
		
  		echo '<h3>Account Settings</h3>';
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$id = $_SESSION['id'];
		if (isset($_POST['submit'])) 
  		{
			$oldpassword = mysqli_real_escape_string($dbc, trim($_POST['oldpassword']));
			$newpassword1 = mysqli_real_escape_string($dbc, trim($_POST['newpassword1']));
			$newpassword2 = mysqli_real_escape_string($dbc, trim($_POST['newpassword2']));
		    $birthpub = mysqli_real_escape_string($dbc, trim($_POST['birthpub']));
		    $error = false;

			if(!empty($oldpassword) && !empty($newpassword1) && !empty($newpassword2)) 
			{
				if(($_SESSION['veripass'] === sha1($oldpassword)) && ($newpassword1 === $newpassword2))
				{
					$query = "UPDATE $table SET password = SHA('$newpassword1') WHERE id = '$id'";
					mysqli_query($dbc, $query);
					echo '<p class="register">Your password has been changed. This will be reflected on your next login.</p>';
				}
				else 
				{ 
					$error = true;
					echo '<p class="error">Your password could not be verified. Please re enter them correctly.</p>'; 
				}
			}
			else 
			{ 
				$error = true;
			}
			if (!$error) 
			{
				$query = "UPDATE $table SET birthpub = '$birthpub' WHERE id = '$id'";
	        	mysqli_query($dbc, $query);
				$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/editprofile.php';
				echo '<p class="register">Your profile has been successfully updated. Click <a href="settings.php">here</a> to go back.</p>';
				require_once('footer.php');
	        	mysqli_close($dbc);
	        	exit();
     		}
		    else 
			{
		    	echo '<p class="error">You must enter all of the profile data.</p>';
		    }
  		}
  		else 
 		{
			// Grab the profile data from the database
			$query = "SELECT date, birthpub FROM $table WHERE id = '$id'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
		
			if ($row != NULL) 
			{
				$date = $row['date'];
				$birthpub = $row['birthpub'];
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	  <table class="register">
	  <tr height="50"><td>
	  		Date Joined
	  </td><td>
      <input type="text" id="date" name="date" class="input" readonly="readonly" value="<?php if (!empty($date)) echo $date; ?>" />
	  </td></tr>
      <tr height="50"><td>
      	Public Birthdate?</label>
      </td><td>
      <?php 
      	echo '<input type="radio" name="birthpub" value="1" ';
      	if($birthpub == 1) echo 'checked';
      	echo '/>Yes';
      	echo '<input type="radio" name="birthpub" value="0" ';
      	if($birthpub == 0) echo 'checked';
      	echo '/>No';
      ?>	
      </td></tr>
	  <tr height="50"><td>
	  Current Password
	  </td><td>
	  <input type="password" id="oldpassword" class="input" name="oldpassword">
	  </td></tr>
	  <tr height="50"><td>
	  	New Password
	  </td><td>
	  <input type="password" id="newpassword1" class="input" name="newpassword1">
	  </td></tr>
	  <tr height="50"><td>
	  	Confirm Password
	  </td><td>
	  <input type="password" id="newpassword2" class="input" name="newpassword2">
	  <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
      </td></tr>
    <tr><td><input type="submit" value="Save Settings" name="submit" class="submit" /></td></tr>
    </table>
  </form>
<?php 
			
			}
			else 
			{
				echo '<p class="error">There was a problem accessing your profile.</p>';
			}
		}
		require_once('footer.php');
	}		
	else 
	{
		echo 'You must be logged in to view this page.';
	} 
?>