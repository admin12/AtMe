<?php
  session_start();
  $user = $_GET['user'];
  $pagetitle = $user . "'s Home";
  $keywords = '@me, atme, user, profile, homepage, users, social, web homepage, internet homepage, ' . $user;
  require_once('navigation.php');
  $table = USER_TABLE;
  $pictable = PIC_TABLE;
  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_GET['id']) && isset($_GET['user'])) 
  {
    $query = "SELECT * FROM $table WHERE id = '" . $_GET['id'] . "'";
  }
  else 
  {
    $query = "SELECT * FROM $table WHERE id = '" . $_SESSION['id'] . "'";
  }
  $data = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($data);
  echo '<h3>View Profile - ' . $row['username'] . '</h3>';
  $id = $row['id'];
  if (mysqli_num_rows($data) == 1) 
  {
    echo '<table class="register">';
    echo '<tr height="30"><td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="Profile Picture" height=130 width=130 /></td></tr>';
    echo '<tr height="30"><td class="label">Name:</td><td class="viewprof">' . $row['name'] . '</td></tr>';
    echo '<tr height="30"><td class="label">Username:</td><td class="viewprof">' . $row['username'] . '</td></tr>';
    echo '<tr height="30"><td class="label">Email Address:</td><td class="viewprof">' . $row['email'] . '</td></tr>';
    echo '<tr height="30"><td class="label">Location:</td><td class="viewprof">' . $row['location'] . '</td></tr>';
    if ($row['birthpub'] == 1)
    {
      echo '<tr height="30"><td class="label">Birthdate:</td><td class="viewprof">' . $row['birthdate'] . '</td></tr>';
    }
    $i = 0;
    echo '<tr><td></td>';
    $query = "SELECT * FROM $pictable WHERE display = '1' AND user = '$id'";
    $data = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_array($data))
    {
    	echo '<td><img src="images/' . $row['path'] . '" alt="' . $row['user'] . '" width=200 height=200 /></td>';
    	$i++;
    	if($i%4 == 0)
    	{
    		echo '</tr><tr><td>/td>';  
    	}  
    }
    echo '</tr>';
	echo '</table>';
    $commenttable = COMMENT_TABLE;
    $comment = "SELECT * FROM $commenttable WHERE user_id = '$id' ORDER BY date DESC LIMIT 15";
    $data = mysqli_query($dbc, $comment);
    echo '<h3>User Comment</h3>';
    echo '<table class="register">';
	if(mysqli_num_rows($data) >= 1)
	{
	    while($row = mysqli_fetch_array($data))
	    {

	    	$userid = $row['posteduser'];
	    	$getuser = "SELECT name, username FROM $table WHERE id = '$userid'";
	    	$convertuser = mysqli_query($dbc, $getuser);
	    	$gotuser = mysqli_fetch_array($convertuser);
	    	$commentdate = explode(' ', $row['date']);
	    	$difference = time() - strtotime($row['date']);
	    	$timetoday = explode(':', date('H:i:s'));
	    	$secondstoday = ($timetoday[0]*3600) + ($timetoday[1]*60) + $timetoday[2];
	    	if($row['showmsg'] == 1)
	    	{
		    	echo '<tr><td><div class="commentname">' . $gotuser['name'] . ':</div><div class="commentdate">';
		    	if ($difference < $secondstoday) //David's Script
		    	      { echo 'today @ ' . $commentdate[1]; }
		    	else
		    	{
		    	       if ($secondstoday + 60*60*24 >= $difference)
		    	       {    echo 'yesterday @' . $commentdate[1]; }
		    	       else
		    	             {  echo $commentdate[0];}
		    	}
		    	echo '</div></td><td class="comment"><div width="500">' . $row['comment'] . '</div></td>';
		    	if(($_SESSION['id'] == $row['posteduser']) || ($_SESSION['id'] == $row['user_id']) || $_SESSION['userlvl'] >= 2) 
		    	{
		    		echo '<td><a href="deletemsg.php?msgid=' . $row['msgid'] . '&user=' . $user . '&poster=' . $row['posteduser'] . '"><div class="error">x</div> </a></td>';
		    	}
		    }
		    if(($row['showmsg'] == 0) && ($_SESSION['userlvl'] >= 2)) 
		    {
		    	echo '<tr><td><div class="hiddenCommentName">' . $gotuser['name'] . ':</div><div class="hiddenCommentDate">';
	
		    	if ($difference < $secondstoday) //David's Script
		    	      { echo 'today @ ' . $commentdate[1]; }
		    	else
		    	{
		    	       if ($secondstoday + 60*60*24 >= $difference)
		    	       {    echo 'yesterday @' . $commentdate[1]; }
		    	       else
		    	             {  echo $commentdate[0];}
		    	}
		    	echo '</div></td><td class="hiddenComment"><div width="500">' . $row['comment'] . '</div></td>';
		    	if(($_SESSION['id'] == $row['posteduser']) || ($_SESSION['id'] == $row['user_id']) || $_SESSION['userlvl'] >= 2) 
		    	{
		    		echo '<td><a href="bringback.php?&id=' . $id . '&msgid=' . $row['msgid'] . '&user=' . $user . '&poster=' . $row['posteduser'] . '"><div class="confirm">Reverse</div> </a></td>';
		    	}
		    }
	    	echo '</tr>'; 
    	}
    }
    else
    {
    	echo '<tr><td></td<td><p class="error">Obviously no one cares about this user.  Be the first to comment and show that you care.</p></td></tr>'; 
    }  	
    if (isset($_SESSION['username']))
    {
    ?>
    	<tr><td></td><td><form enctype="multipart/form-data" method="post" action="comment.php">
    	<input type="hidden" name="wall" id="wall" value="<?php echo $id; ?>" />
    	<input type="hidden" name="username" id="username" value="<?php echo $user; ?>" />
    	<textarea name="comment" id="comment" class="contbox" rows="5" cols="25"></textarea><br />
    	<input type="submit" value="Post Comment" name="postcomment" /></td></tr>
    	</form></td></tr>
    <?php
     }
    echo '</table>';
  } 
  else 
  {
    echo '<p class="error">There was a problem accessing your profile.</p>';
  }
  require_once ('footer.php');
?>