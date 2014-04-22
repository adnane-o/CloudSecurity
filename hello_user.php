<?php

	session_start();
	$username = $_SESSION['login'];
	echo "Hello, <i>$username</i>";
	echo "<a href='disconnect.php'>Log out</a>";

?>