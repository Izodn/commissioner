<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/application.php'; //ALWAYS INCLUDE THIS
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Commissioner - Logout</title>
	</head>
	<body>
		<center>
			<p>You've been logged out.</p>
			<br>
			<a href="login.php">Click here</a> to login
		</center>
	</body>
</html>