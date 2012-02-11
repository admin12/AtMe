<?php
	session_start();
	$pagetitle = "Administration";
	require_once('navigation.php');
	if((isset($_SESSION['id'])) && ($_SESSION['userlvl'] == 3))
	{
		$action = $_GET['action'];
		$getid = $_GET['id'];
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$userTable = USER_TABLE;
		$commentTable = COMMENT_TABLE;
		$timeTable = TIME_TABLE;
		//Function for search
		function search($search, $table, $dbc)
		{
			if(!empty($search))
			{
				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				$query = "SELECT * FROM $table WHERE userlvl = '1' AND (username LIKE '%$search%' OR name LIKE '%$search%')";
				$data = mysqli_query($dbc, $query);
				
				if (mysqli_num_rows($data) > 0)
				{	
					echo '<table>';
					while ($rows = mysqli_fetch_array($data))
					{
						echo '<tr><td>';
						echo $rows['name'] . ' (' . $rows['username'] . ') ';
						echo adminOptions($rows);
						echo '</td></tr>';
					}
					echo '</table>';
				}
				else
					echo '<span class="error">Please refine your search.</span>';
			}
			else 
				echo '<span class="error">You must search for something.</span>';
		}	
		//Function to remove admin or mod
		function makeUser($id, $table, $db) 
		{
			$query = "UPDATE $table SET userlvl = '1' WHERE id = '$id'";
			mysqli_query($db, $query);
		}
		//Function to make mod
		function makeMod($id, $table, $db) 
		{
			$query = "UPDATE $table SET userlvl = '2' WHERE id = '$id'";
			mysqli_query($db, $query);
		}
		//Function to make admin
		function makeAdmin($id, $table, $db) 
		{
			$query = "UPDATE $table SET userlvl = '3' WHERE id = '$id'";
			mysqli_query($db, $query);
		}
		//Function to deactivate account
		function deactivate($id, $table, $db) 
		{
			$query = "UPDATE $table SET confirm = '0' WHERE id = '$id'";
			mysqli_query($db, $query);
		}
		//Function to deactivate account
		function activate($id, $table, $db) 
		{
			$query = "UPDATE $table SET confirm = '1' WHERE id = '$id'";
			mysqli_query($db, $query);
		}
		//Function Backup Database
		function backupDB($table) 
		{
			require_once('constants.php');
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			
			$file = 'backup/' . $table . DATE('YmdHis') . '.sql';
			$query = "SELECT * INTO OUTFILE '$file' FROM $table";
			mysqli_query($dbc, $query);

		}
		//function for admin options
		function adminOptions($row)
		{
			if($row['userlvl'] != 3) echo '<a href="admin.php?action=makeadmin&id=' . $row['id'] . '"><span class="admopt"> Admin</span></a> ';
			if($row['userlvl'] != 2) echo '<a href="admin.php?action=makemod&id=' . $row['id'] . '"><span class="admopt"> Mod</span></a> ';
			if($row['userlvl'] != 1) echo '<a href="admin.php?action=makeuser&id=' . $row['id'] . '"><span class="admopt"> User</span></a>';
			if($row['confirm'] == 0) echo '<a href="admin.php?action=activate&id=' . $row['id'] . '"><span class="admopt"> Activate</span></a>';
			if($row['confirm'] == 1) echo '<a href="admin.php?action=deactivate&id=' . $row['id'] . '"><span class="admopt"> Deactivate</span></a>';
			echo '<br />';
		}
		function resetCounter($dbc)
		{
			$query1 = "DELETE FROM atme_pageloads";
			mysqli_query($dbc, $query1);
			$query2 = "ALTER TABLE atme_pageloads AUTO_INCREMENT = 1";
			mysqli_query($dbc, $query2);
		}
		
		if($action == 'resetcounter')
		{
			resetCounter($dbc);
			echo '<p class="error">Page Load Counters have been reset</p>';
		}
		else if($action == 'makeuser')
		{
			makeUser($getid, $userTable, $dbc);
			$query = "SELECT name, username FROM $userTable WHERE id = '$getid'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			echo '<p class="error">User ' . $row['username'] . ' has <b>become a simple user</b>.</p>';
		}
		else if($action == 'makemod')
		{
			makeMod($getid, $userTable, $dbc);
			$query = "SELECT name, username FROM $userTable WHERE id = '$getid'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			echo '<p class="error">User ' . $row['username'] . ' has <b>become a moderator</b>.</p>';
		}
		else if($action == 'makeadmin')
		{
			makeAdmin($getid, $userTable, $dbc);
			$query = "SELECT name, username FROM $userTable WHERE id = '$getid'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			echo '<p class="error">User ' . $row['username'] . ' has <b>become an administrator</b>.</p>';
		}
		else if($action == 'deactivate')
		{
			deactivate($getid, $userTable, $dbc);
			$query = "SELECT name, username FROM $userTable WHERE id = '$getid'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			echo '<p class="error">User ' . $row['username'] . ' has been <b>deactivated</b>.</p>';
		}
		else if($action == 'activate')
		{
			activate($getid, $userTable, $dbc);
			$query = "SELECT name, username FROM $userTable WHERE id = '$getid'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			echo '<p class="error">User ' . $row['username'] . ' has been <b>activated</b>.</p>';
		}
		else if($action == 'backup')
		{
			backupDB($_GET['table']);
			echo '<p class="error">Table ' . $_GET['table'] . ' has been <b>saved</b>.</p>';
		}
		echo '<h3>Statistics</h3><table>';
		//Find the number of registered users
		$numOfRegUsers = "SELECT id FROM $userTable";
		$data1 = mysqli_query($dbc, $numOfRegUsers);
		echo '<tr><td class="labels">Number of Registered Users:</td><td class="comment">' . mysqli_num_rows($data1) . '</td></tr>';
		
		//Find the number of activated users
		$numOfConUsers = "SELECT id FROM $userTable WHERE confirm = '1'";
		$data2 = mysqli_query($dbc, $numOfConUsers);
		echo '<tr><td class="labels">Number of Activated Users:</td><td class="comment">' . mysqli_num_rows($data2) . '</td></tr>'; 
		
		//Find the number of Messages posted
		$numOfMessages = "SELECT msgid FROM $commentTable WHERE showmsg = '1'";
		$dataMsg = mysqli_query($dbc, $numOfMessages);
		echo '<tr><td class="labels">Number of Messages Posted:</td><td class="comment">' . mysqli_num_rows($dataMsg) . '</td></tr>'; 
		
		//Find the average page load time
		$avgLoad = "SElECT id, time FROM $timeTable";
		$dataAvgLoad = mysqli_query($dbc, $avgLoad);
		$numItems = mysqli_num_rows($dataAvgLoad);
		echo '<tr><td class="labels">Average Overall Load Time:</td><td class="comment">';
		if(!empty($numItems))
		{
			while($row = mysqli_fetch_array($dataAvgLoad))
			{
				$totalTime += $row['time'];
			}
			$avgTime = $totalTime / $numItems;
			if($avgTime >= 500)	
				echo '<span class="error">' . number_format($avgTime, 2) . 'ms</span>';
			else
				echo '<span class="confirm">' . number_format($avgTime, 2) . 'ms</span>';
		}	
		else
			echo '<span class="admopt">Not enough data on this page</span><br />';
		echo '</td></tr>';
		$totalTime = 0;
		$avgTime = 0;
		$numItems = 0;
		
		function loadTime($dbc, $page)
		{
			$indexTime = "SELECT * FROM atme_pageloads WHERE page LIKE '%$page%'";
			$dataAvgLoad = mysqli_query($dbc, $indexTime);
			$numItems = mysqli_num_rows($dataAvgLoad);
			if(!empty($numItems))
			{
				while($row = mysqli_fetch_array($dataAvgLoad))
				{
					$totalTime += $row['time'];
				}
				$avgTime = $totalTime / $numItems;
				echo $page . ': ';
				if($avgTime >= 500)	
					echo '<span class="error">' . number_format($avgTime, 2) . 'ms</span><br />';
				else
					echo '<span class="confirm">' . number_format($avgTime, 2) . 'ms</span><br />';	
			}
			else
				echo $page . ': <span class="admopt">Not enough data on this page</span><br />';
			
		}
		echo '<tr><td class="labels" valign="top">Average Load Time Per Page:<br />';
		echo '<a href="admin.php?action=resetcounter"><span class="admopt">[Reset Counters]</span></a>';
		echo '</td><td class="comment">';
		loadTime($dbc, 'index.php');
		loadTime($dbc, 'viewprofile.php');
		loadTime($dbc, 'editprofile.php');
		loadTime($dbc, 'settings.php');
		loadTime($dbc, 'admin.php');
		loadTime($dbc, 'register.php');
		loadTime($dbc, 'contact.php');
		loadTime($dbc, 'search.php');
		
		echo '</td></tr>';
		echo '</table>';
		echo '<h3>Administrative Tasks</h3>';
		echo '<table>';
		
		//Backup Database
		/*echo '<tr><td class="commentname" valign="top">Backup Table:</td><td class="comment">';
		echo '<form enctype="multipart/form-data" method="get" action="admin.php?action=backup">';
			echo '<select name="table">';
			echo '<option value="' . $userTable . '">User Table</option>';
			echo '<option value="' . $commentTable . '">Comment Table</option>';
			echo '</select>';
			echo '<input type="submit" id="submit" value="go" />';
		echo '</form>';
		echo '</td></tr>';*/
		
		//List of administrators
		$listOfAdmin = "SELECT id, userlvl, confirm, name, username FROM $userTable WHERE userlvl = '3'";
		$data3 = mysqli_query($dbc, $listOfAdmin);
		echo '<tr><td class="labels" valign="top">Administrators:</td><td class="comment">';
		while($row = mysqli_fetch_array($data3))
		{
			echo $row['name'] . ' (' . $row['username'] . ') ';
			echo adminOptions($row);
		}
		echo '</td></tr>';
		
		//List of Moderators
		$listOfMods = "SELECT id, userlvl, confirm, name, username FROM $userTable WHERE userlvl = '2'";
		$data4 = mysqli_query($dbc, $listOfMods);
		echo '<tr><td class="labels" valign="top">Moderators:</td><td class="comment">';	
		while($row = mysqli_fetch_array($data4))
		{
			echo $row['name'] . ' (' . $row['username'] . ') ';
			echo adminOptions($row);
		}
		echo '</td></tr>';
		
		//List of Users
		echo '<tr><td class="labels" valign="top">Users:</td><td class="comment">';
		echo '<div class="search"><form  enctype="multipart/form-data" method="post" action="admin.php?action=search">';
		echo '<input type="text" name="search" id="search" class="adminbox" />';
		echo '<input type="submit" name="submit" value="submit" /></form></div>';
		if($action == 'search')
		{
			$searchquery = $_POST['search'];
			echo search($searchquery, $userTable, $dbc);
		}
		echo '</td></tr>';
		
		echo '</table>';
	}
	else 
	{
		echo '<p class="error">You are not priviledged enough to be here.</p>';
	}
	require_once('footer.php');
	?>