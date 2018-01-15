<?php

    $db = parse_ini_file("connection.ini");
    $connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("INSERT INTO tasklist (title, userId)
    VALUES (:title, :userId)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':userId', $userId);

	$title = $_POST['listTitle'];
    session_start();
    $userId = $_SESSION["userId"];
    $_SESSION["userId"] = $userId;
    $stmt->execute();
	
	header('Location:' . 'display.php?listTitle=' . $title);
	Redirect('display.php');
	exit();
?>