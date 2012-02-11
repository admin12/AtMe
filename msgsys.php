<?php
	function comment($dbc, $id, $pic)
	{
		function showTime($date)
		{
			$commentdate = explode(' ', $date);
			$difference = time() - strtotime($date);
			$timetoday = explode(':', date('H:i:s'));
			$secondstoday = ($timetoday[0]*3600) + ($timetoday[1]*60) + $timetoday[2];
			if ($difference < $secondstoday) //David's Script
			{
				$msg = 'Today @ ' . $commentdate[1]; 
				return $msg;
			}
			else
			{
			       if ($secondstoday + 60*60*24 >= $difference)
			       {
			       		$msg = 'Yesterday @' . $commentdate[1];
			       		return $msg;
			       }
			       else
			            return $commentdate[0];
			}
		}
		$commenttable = COMMENT_TABLE;
		$usertable = USER_TABLE;
	    $query = "SELECT * FROM $commenttable WHERE user_id = '$id' AND pic_id = '$pic' ORDER BY date DESC";
	    $data = mysqli_query($dbc, $query);
	    
		if(mysqli_num_rows($data) >= 1)
		{
			$i = 0;
			echo '<h4>Comments</h4>';
		    while($row = mysqli_fetch_array($data))
		    {
		    	
		    	$poster = $row['posteduser'];
		    	$getuser = "SELECT id, name, username FROM $usertable WHERE id = '$poster'";
		    	$convertuser = mysqli_query($dbc, $getuser);
		    	$gotuser = mysqli_fetch_array($convertuser);
		    	//echo '<span class="error">'.$error_msg.'</span>';
		    	echo '<div class="comment-container">';
		    	if($row['showmsg'] == 1)
		    	{
			    	echo '<div>';
			    		$comment = preg_replace('/([a-zA-Z]{50})/', '$1 ', $row['comment']);
			    		echo '<div class="comment-right">'.$comment.'</div>';
			    		echo '<div class="comment-left"><a href="viewprofile.php?id='.$gotuser['id'].'&user='.$gotuser['username'].'" class="comment">'.$gotuser['name'].'</a><br /><span class="date">'.showTime($row['date']).'</span></div>';
			    	echo '</div>';
			    	
			    }
			    echo '</div>';
			    $i++;
	    	}
	    }
	    else
	    {
	    	echo '<p class="error">Obviously no one cares about this user.  Be the first to comment and show that you care.</p>'; 
	    }  	
	    if (isset($_SESSION['id']))
	    {
		    
		    ?>
		    	<form enctype="multipart/form-data" method="post" action="comment.php">
		    	<input type="hidden" name="wall" value="<?php echo $id; ?>" />
		    	<input type="hidden" name="username" value="<?php echo $user; ?>" />
		    	<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
		    	<input type="hidden" name="picid" value="<?php echo $pic; ?>" />
		    	<textarea name="comment" id="comment" class="contbox" rows="3" cols="25"></textarea><br />
		    	<input type="submit" value="Post Comment" name="postcomment" class="submit" /></td></tr>
		    	</form>
		    <?php
	     }
	}
?>