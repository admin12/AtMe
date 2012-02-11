<?php
  session_start();
  $pagetitle = 'Your Home on the Web';
  $keywords = '@me, atme, homepage, users, social, web homepage, internet homepage';
  require_once('navigation.php');

	  $table = USER_TABLE;
	  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
	
	  $query = "SELECT id, confirm, name, username, picture FROM $table WHERE confirm = '1' ORDER BY date DESC LIMIT 18";
	  $data = mysqli_query($dbc, $query);
	
	  echo '<h3>Latest members:</h3>';
	  echo '<table cellpadding=7><tr>';
	 // echo '<ul id="first">';	 
	  $i = 0;
		while ($row = mysqli_fetch_array($data)) 
		{
			if($row['confirm'] == 1)
		  	{
		  	?>
				<td>
				
				<?php
				echo '<a href="viewprofile.php?id=' . $row['id'] . '&user=' . $row['username'] . '"><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['name'] . '" class="imgBorder3" width=160 height=160 /></a>';
				?>
				
				</td>
			<?php	
				$i++;
				if($i%6 == 0) echo '</tr><tr>';	    
		    }	
		}
	  //echo '</ul>';
	  echo '</tr>';
	  echo '</table>';
	  require_once('footer.php');
?>
<script type='text/javascript' />    
$('ul#first a').imgPreview();
</script>