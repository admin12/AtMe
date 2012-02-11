</div>
	<div id="footer">
	<span class="footertext">
	All Information Copyright &copy; 2010 - @ME Inc, All Rights Reserved.
	<a href="main.php">Home</a> - 
	<a href="#">About Us</a> - 
	<a href="contact.php">Contact Us</a> 
		<?php 
			$timeTable = TIME_TABLE;
			$load = microtime();
			$loadTime = (1000*number_format($load, 4));
			echo 'Page loaded in '. $loadTime .'ms';
			$page = explode('/', $_SERVER["REQUEST_URI"]);
			$query = "INSERT INTO $timeTable (page, time) VALUES ('$page[1]', '$loadTime')";
			mysqli_query($dbc, $query);
			mysqli_close($dbc); 
		?>
	</span>
</div>
</body>
</html>