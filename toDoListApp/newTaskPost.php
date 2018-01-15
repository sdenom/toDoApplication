<?php

    $db = parse_ini_file("connection.ini");
    $connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("INSERT INTO task (title, listId, description, dueDate, status)
    VALUES (:title, :listId, :description, :dueDate, :status)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':listId', $listId);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':dueDate', $dueDate);
    $stmt->bindParam(':status', $status);

    $status = "Pending";

    $title = $_POST['title'];
    $listId = $_POST['listId'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];

    $stmt->execute();

    header('Location:' . 'display.php');
    exit();

?>