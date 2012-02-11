<?php
	session_start();
	require_once('constants.php');
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$pagetitle = 'upload photo';
	$keywords = '@me, atme, profile, edit profile, users, social, web homepage, internet homepage' . $_SESSION['username'];
 	$table = USER_TABLE;
 	$pictable = PIC_TABLE;
	if(isset($_SESSION['id']))
	{
		$id = $_SESSION['id'];
		$postdate = DATE('Y-m-d g:i:sa');
		if (isset($_POST['submit'])) 
  		{
		    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
		    $disp = mysqli_real_escape_string($dbc, trim($_POST['disp']));
		    $new_picture_type = $_FILES['new_picture']['type'];
		    $new_picture_size = $_FILES['new_picture']['size']; 
		    list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
		    $error = false;

    		if (!empty($new_picture)) 
			{
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
			if (!$error) 
			{
				if(!empty($new_picture))
				{
					$querypic = "INSERT INTO $pictable (user, date, path) VALUES ('$id', '$postdate', '$filename')";
					mysqli_query($dbc, $querypic);
				}
				$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewprofile.php';
				header('location: '.$home_url);
     		}
  		} 
	}		
	else 
	{
		echo 'You must be logged in to view this page.';
	} 
?>