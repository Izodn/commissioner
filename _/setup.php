<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/application.php'; //ALWAYS INCLUDE THIS
	require_once $_SERVER['DOCUMENT_ROOT'].'/_/include/class/user.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/_/include/dbh.php';
	session_start();
	global $dbh;
	$query = <<<SQL
SELECT
	iUserId
FROM
	COM_USER
LIMIT
	0,1
SQL;
	$runQuery = $dbh->prepare($query);
	$runQuery->execute();
	$result = $runQuery->fetch(PDO::FETCH_ASSOC);
	if( $result !== false ) { //User found navigate away
		header('Location: /login.php');
		die();
	}
	if( isset($_POST['register']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['rPassword']) ) {
		if( $_POST['password'] !== $_POST['rPassword'] ) {
			$errMsg = "Passwords must match";
		}
		else {
			$userObj = new user($_POST['email'], $_POST['password']);
			if(!$userObj->doCreate($_POST['firstName'], $_POST['lastName'], 'superuser')) {
				$errMsg = $userObj->errMsg;
			}
			else {
				$_SESSION['userObj'] = $userObj;
				header('Location: /'); //Successfully registered goto index
			}
		}
	}
	elseif( isset($_POST['register']) ) {
		$errMsg = "Please fill out all fields";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Commissioner - Setup</title>
	</head>
	<body>
		<center>
			<h3>Setup</h3>
			<form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
				<table>
					<tr>
						<td>First Name: </td>
						<td><input type="text" name="firstName"></td>
					</tr>
					<tr>
						<td>Last Name: </td>
						<td><input type="text" name="lastName"></td>
					</tr>
					<tr>
						<td>Email: </td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr>
						<td>Password: </td>
						<td><input type="password" name="password"></td>
					</tr>
					<tr>
						<td>Repeat Password: </td>
						<td><input type="password" name="rPassword"></td>
					</tr>
					<tr>
						<td><input type="submit" name="register" value="Create Superuser"></td>
					</tr>
				</table>
			</form>
			<?php echo ($errMsg = isset($errMsg) ? '<font color="#FF0000">'.$errMsg.'</font>' : "")."\n"; ?>
		</center>
	</body>
</html>