<?php
	session_start();
	$pagetitle = 'Search Results for ' . $_GET['search'];
	$keywords = '@me, atme, search, results, homepage, users, social, web homepage, internet homepage' . $_GET['search'];
	require_once('constants.php');
  	$table = USER_TABLE;
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$search = $_GET['search'];
	$query = "SELECT * FROM $table WHERE confirm = '1' AND (username LIKE '%$search%' OR name LIKE '%$search%')";
	$data = mysqli_query($dbc, $query);
	
	if(mysqli_num_rows($data) == 1)
	{
		$rows = mysqli_fetch_array($data);
		$pro_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'viewprofile.php?id=' .$rows['id'] . '&user=' . $rows['username'];
		header('Location: ' . $pro_url);
	}
	else if (mysqli_num_rows($data) > 1)
	{
		require_once('navigation.php');
		echo '<table class="moveTable" cellspacing="20">';
		while ($rows = mysqli_fetch_array($data))
		{
			echo '<tr><td>';
			echo '<a href="viewprofile.php?id=' . $rows['id'] . '&user=' . $rows['username'] . '"><img src="images/' . $rows['picture'] . '" height=100 width=100 class="imgBorder2" /></a>';
			echo '</td><td>';
			echo '<a href="viewprofile.php?id=' . $rows['id'] . '&user=' . $rows['username'] . '">'. $rows['username'] . '</a><br />';
			echo $rows['name'];
			echo '</td></tr>';
		}
		echo '</table>';
	}
	else
	{
		require_once('navigation.php');
		echo '<p class="error">Please refine your search.</p>';
	}
	
	require_once('footer.php');
?>