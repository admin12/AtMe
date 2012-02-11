<?php
  session_start();
  $pagetitle = 'Your Home on the Web';
  $keywords = '@me, atme, homepage, users, social, web homepage, internet homepage';
  require_once('navigation.php');
  if(isset($_SESSION['id']))
  {
	  $table = USER_TABLE;
	  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
	
	  $query = "SELECT id, confirm, name, username, picture FROM $table WHERE confirm = '1' ORDER BY date DESC LIMIT 18";
	  $data = mysqli_query($dbc, $query);
	
	  echo '<h3>Latest members:</h3>';
	  echo '<table cellpadding=7 align="center"><tr>';	 
	  $i = 0;
		while ($row = mysqli_fetch_array($data)) 
		{
			if($row['confirm'] == 1)
		  	{
				echo '<td><a href="viewprofile.php?id=' . $row['id'] . '&user=' . $row['username'] . '"><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['name'] . '" class="latestmembers" width=140 height=140 /></a></td>';
				$i++;
				if($i%6 == 0) echo '</tr><tr>';	    
		    }	
		}
	  echo '</tr><tr>';
	
	  echo '</tr>';
	  echo '</table>';
	  require_once('footer.php');
  }
  else
  	echo 'You must be logged in to view this page';
?>