<?php

	$connection = new PDO("mysql:dbname=todo;host=localhost:3306", 'root', 'password123');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("INSERT INTO tasklist (title, userId)
    VALUES (:title, :userId)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':userId', $userId);

	$title = $_POST['listTitle'];
    $userId = $_POST['userId'];
    $stmt->execute();
	
	header('Location:' . 'display.php?listTitle=' . $title);
	//Redirect('display.php');
	exit();
?>