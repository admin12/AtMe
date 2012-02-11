<?php
	session_start();
	$pagetitle = 'Edit Profile - ' . $_SESSION['username'];
	$keywords = '@me, atme, profile, edit profile, users, social, web homepage, internet homepage' . $_SESSION['username'];
	require_once('navigation.php');
 	$table = USER_TABLE;
 	$pictable = PIC_TABLE;
	if(isset($_SESSION['id']))
	{
  		echo '<h3>Edit Profile</h3>';
		$id = $_SESSION['id'];
		$postdate = DATE('Y-m-d g:i:sa');
		if (isset($_POST['submit'])) 
  		{

		    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
		    $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
		    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
			$old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
		    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
		    $year = mysqli_real_escape_string($dbc, trim($_POST['year']));
		    $month = mysqli_real_escape_string($dbc, trim($_POST['month']));
		    $disp = mysqli_real_escape_string($dbc, trim($_POST['disp']));
		    $day = mysqli_real_escape_string($dbc, trim($_POST['day']));
		    $birthdate = $year . "-" . $month . "-" . $day;
		    $new_picture_type = $_FILES['new_picture']['type'];
		    $new_picture_size = $_FILES['new_picture']['size']; 
		    $error = false;

			echo $disp;

    		if (!empty($new_picture)) 
			{
				list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
		    	if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
		        ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
		        ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) 
				{
        			if ($_FILES['file']['error'] == 0) 
					{
						$date = DATE('YmdHis');
						$ext = explode('.', basename($new_picture));
						$filename = $username . $date . "." . end($ext);
		          		$target = MM_UPLOADPATH . $filename;
		          		if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) 
						{
		            		if (!empty($old_picture) && ($old_picture != $new_picture)) 
							{
		              			@unlink(MM_UPLOADPATH . $old_picture);
		            		}
		          		}
					}
		          	else 
					{
		            	@unlink($_FILES['new_picture']['tmp_name']);
		            	$error = true;
		            	echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
		          	}
       		 	}
       		 	else 
       		 	{
					@unlink($_FILES['new_picture']['tmp_name']);
					$error = true;
					echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
					  ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
       		 	}
			}
			if(empty($name) || empty($year) ||  empty($username) || empty($location) || empty($email))
			{
				$error = true;
			}
			
			if (!$error) 
			{
				if(!empty($new_picture))
				{
					$querypic = "INSERT INTO $pictable (user, date, path) VALUES ('$id', '$postdate', '$filename')";
					mysqli_query($dbc, $querypic);
				}
				if($disp == true)
				{
					$query = "UPDATE $table SET birthdate = '$birthdate', name = '$name', location = '$location', email = '$email', picture = '$filename' WHERE id = '$id'";
				}
				else 
				{
					$query = "UPDATE $table SET birthdate = '$birthdate', name = '$name', location = '$location', email = '$email' WHERE id = '$id'";
				}
	        	mysqli_query($dbc, $query);
				$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/editprofile.php';
				echo '<p class="register">Your profile has been successfully updated. Click <a href="editprofile.php">here</a> to go back.</p>';
     		}
		    else 
			{
		    	echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
		    }
  		} 
  		else 
 		{
			$query = "SELECT * FROM $table WHERE id = '$id'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
		
			if ($row != NULL) 
			{
				$date = $row['date'];
				$name = $row['name'];
				$username = $row['username'];
				$email = $row['email'];
				$bday = explode('-', $row['birthdate']);
				$day1 = $bday[2];
				$month1 = $bday[1];
				$year1 = $bday[0];
				$location = $row['location'];
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	  <table class="moveTable">
	  <tr height="50"><td>
	  		Date Joined
	  </td><td>
      <input type="text" id="date" name="date" class="input" readonly="readonly" value="<?php if (!empty($date)) echo $date; ?>" />
	  </td></tr>
	  <tr height="50"><td>
	  	Username
	  </td><td>
	  <input type="text" id="username" class="input" name="username" readonly="readonly" value="<?php if (!empty($username)) echo $username; ?>" />
	  </td></tr>
	  <tr height="50"><td>
      		Name
      </td><td>
      <input type="text" id="name" name="name" class="input" value="<?php if (!empty($name)) echo $name; ?>" />
       </td></tr>
       <tr height="50"><td>
       		Location
       </td><td>
       <input type="text" id="location" name="location" class="input" value="<?php if (!empty($location)) echo $location; ?>" />
        </td></tr>
      <tr height="50"><td>
      	Date of Birth
      </td><td>
      <select name="year">
      	<?php require_once('year.php'); ?>
      </select>
      <select name="month">
      	<?php require_once('month.php'); ?>
      </select>
      <select name="day">
      	<?php require_once('day.php'); ?>
      </select>
      </td></tr>
	  <tr height="50"><td>
	  	Email
      </td><td>
      <input type="text" id="email" class="input" name="email" value="<?php if (!empty($email)) echo $email; ?>" />
	  </td></tr>
	  <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
      </td></tr>
      <tr height="50"><td valign="top">
      	Picture
      </td><td>
      <input type="file" id="new_picture" name="new_picture" class="profiles" /><input type="checkbox" name="disp" id="disp" value="true" />Display Pic?<br />
      <?php 
      if (!empty($old_picture)) 
      {
        echo '<img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
      } 
      echo '<br /><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['name'] . '" width=100 height=100 />'; 
      ?>
      </td></tr>
    <tr><td>
    <input type="submit" value="Save Profile" name="submit" class="submit" /></td></tr>
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