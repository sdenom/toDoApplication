<?php

	session_start();

	$db = parse_ini_file("connection.ini");
	$connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("SELECT userId FROM user WHERE username = :username AND password = :password");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);

	$username = $_POST['username'];
	$password = $_POST['password'];

	$stmt->execute();

	$result = $stmt->fetchAll();

	// Either the username doesn't exist or password is wrong
	if (sizeof($result) == 0)
	{
		$stmt = $connection->prepare("SELECT userId FROM user WHERE username = :username");
		$stmt->bindParam(':username', $username);

		$stmt->execute();

		$result = $stmt->fetchAll();
		
		// If the username does not exist in the database create new user
		if (sizeof($result) == 0)
		{
			$stmt = $connection->prepare("INSERT INTO user (username, password)
											VALUES (:username, :password)");
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);
			$stmt->execute();
			
			$userId = $connection->lastInsertId();
			
			$_SESSION["userId"] = $userId;

			header('Location:' . 'display.php');
			exit();
		}
		else  // When username is correct but password is wrong
		{	
			echo "Incorrect password</br>";
			echo "<a href='index'>Return to login</a>";
		}
	}
	else  //the username and password are right
	{
		$userId = $result[0]['userId'];
		$_SESSION["userId"] = $userId;

		header('Location:' . 'display.php');
		exit();
	}
	
?>