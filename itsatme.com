<?php
  session_start();
  $get_id = $_GET['id'];
  $get_user = $_GET['user'];
  
  $pagetitle = $get_user . "'s Home";
  $keywords = '@me, atme, user, profile, homepage, users, social, web homepage, internet homepage, ' . $get_user;
  require_once('navigation.php');
  require_once('msgsys.php');
  
  $usertable = USER_TABLE;
  $pictable = PIC_TABLE;
  
  if(isset($_SESSION['id']))
  {
	  if (isset($get_id) && isset($get_user)) 
	    $query = "SELECT * FROM $usertable WHERE id = '$get_id'";
	  else 
	  {
	  	$sessionID = $_SESSION['id'];
	    $query = "SELECT * FROM $usertable WHERE id = '$sessionID'";
	  }
	  
	  $row = mysqli_fetch_array(mysqli_query($dbc, $query));
	  
	  $user_id = $row['id'];
	  $user_username = $row['username'];
	  $user_name = $row['name'];
	  $user_email = $row['email'];
	  $user_location = $row['location'];
	  $user_birthdate = $row['birthdate'];
	  $user_birthpub = $row['birthpub'];
	  
	  echo '<h3>'.$user_name.'\'s Home</h3><div class="media"><a href="viewalbum.php?a='.$user_id.'&b='.$user_username.'" class="button"><span class="photos">Photos</span></a><a href="#" class="button"><span class="music">Music</span></a><a href="#" class="button"><span class="videos">Videos</span></a></div>';
	  if (mysqli_num_rows(mysqli_query($dbc, $query)) == 1) 
	  {
	  	
	  	echo '<div class="profile-container">';
		    echo '<div class="profile-information">';
		    	echo '<div class="info-right">'.$user_name.'</div><div class="info-left">Name</div>';
		    	echo '<div class="info-right">'.$user_username.'</div><div class="info-left">Username</div>';
		    	echo '<div class="info-right">'.$user_email.'</div><div class="info-left">Email</div>';
		    	echo '<div class="info-right">'.$user_location.'</div><div class="info-left">Location</div>';
		    	if ($user_birthpub == 1)
		    		echo '<div class="info-right">'.$user_birthdate.'</div><div class="info-left">Birthdate</div>';
		    	    		
		    echo '</div>';
			echo '<div class="display-picture">';
		    	echo '<a href="viewphoto.php?id='.$user_id.'&user='.$user_username.'&picid='.$user_id.'&display=true">';
		    	echo '<img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="Profile Picture" height=100 width=100 class="imgBorder2" /></a>';
		    echo '</div>';
		echo '</div>';
		
		$query = "SELECT * FROM $pictable WHERE user = '$user_id' LIMIT 4";
		$data = mysqli_query($dbc, $query);
		$i = 0;
		if(mysqli_num_rows($data) >= 1)
		{
			echo '<div class="info-across">';
			echo '<table border=0 cellspacing=15><tr>';
			while($row = mysqli_fetch_array($data))
			{
				$pic_picid = $row['pic_id'];
				$pic_user = $row['user'];
				$pic_date = $row['date'];
				$pic_path = $row['path'];
				
				echo '<td><a href="viewphoto.php?id='.$user_id.'&user='.$user_username.'&picid='.$pic_picid.'&display=false"><img src="images/' . $row['path'] . '" alt="' . $row['user'] . '" width=200 height=200 class="imgBorder2" /></a></td>';
				$i++;
				if($i%4 == 0) 
					echo '</tr><tr>';
			}
			echo '</tr></table>';
			echo '</div>';
		}
		echo '<div class="profile_comment">';
			echo comment($dbc, $user_id, 0);
		echo '</div>';
	  } 
	  else 
	  {
	    echo '<p class="error">There was a problem accessing your profile.</p>';
	  }
	  require_once ('footer.php');
}
else
	echo 'You must be logged in to view this page.';
?>