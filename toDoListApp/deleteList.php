<?php

	$db = parse_ini_file("connection.ini");
    $connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $listId = $_GET['listId'];

        $stmt = $connection->prepare("DELETE FROM task
        WHERE listId = :listId ");
        $stmt->bindParam(':listId', $listId);
        $stmt->execute();

        $stmt = $connection->prepare("DELETE FROM taskList
        WHERE listId = :listId ");
        $stmt->bindParam(':listId', $listId);
        $stmt->execute();
	
	header('Location:' . 'display.php');
    exit();
?>