<?php

	$connection = new PDO("mysql:dbname=todo;host=localhost:3306", 'root', 'password123');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("INSERT INTO task (title, listId, description, dueDate, status)
    VALUES (:title, :userId, :description, :dueDate, :status)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':listId', $listId);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':dueDate', $dueDate);
    $stmt->bindParam(':status', $status);

    $status = "pending";

    $title = $_POST['title'];
    $listId = $_POST['listId'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    print_r($dueDate);

    //$stmt->execute();

?>