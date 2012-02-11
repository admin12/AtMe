<?php
session_start();

$get_id = $_GET['a'];
$get_user = $_GET['b'];

$pagetitle = 'Photos of ' . $username;
$keywords = '@me, atme, homepage, users, social, web homepage, internet homepage';
require_once('navigation.php');
require_once('msgsys.php');

$pictable = PIC_TABLE;
$usertable = USER_TABLE;

if(isset($_SESSION['id']))
{
	?>
	<div class="upload">
	<form enctype="multipart/form-data" method="post" action="uploadphoto.php">
	    <input type="hidden" name="MAX_FILE_SIZE" value="MM_MAXFILESIZE" />
		<table>
		<tr><td class="commentdate">
		<input type="file" id="new_picture" name="new_picture" class="commentdate" />
		<input type="hidden" name="disp" id="disp" value="false" />
		<input type="submit" value="Upload" name="submit" /></td></tr>
		</table>
	</form>
	</div>
	<?php
	echo '<h3>Photo Album - '.$get_user.'</h3>';
	$query = "SELECT * FROM $pictable WHERE user = '$get_id'";
	$data = mysqli_query($dbc, $query);
	
	echo '<table cellpadding=7><tr>';	 
	  $i = 0;
		while ($row = mysqli_fetch_array($data)) 
		{
			echo '<td><a href="images/'.$row['path'].'" rel="lightbox['.$get_id.'" title="'.$row['description'].'"><img src="images/'.$row['path'].'" height=200 width=200 alt="'.$row['description'].'" class="imgBorder3" /> </a></td>';
			$i++;
			if($i%6 == 0) echo '</tr><tr>';	    
		}
	  echo '</tr>';
	  echo '</table>';
	
	
	require_once('footer.php');
	
}
?>