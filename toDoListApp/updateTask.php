<?php
	$db = parse_ini_file("connection.ini");
	$connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $status = $_GET['status'];
    $taskId = $_GET['taskId'];

    if($status=="Deleted")
    {
        $stmt = $connection->prepare("DELETE FROM task
    	WHERE taskId = :taskId ");
    	$stmt->bindParam(':taskId', $taskId);
    	$stmt->execute();
    }
    else
    {
    	$stmt = $connection->prepare("UPDATE task
    		SET status = :status
    		WHERE taskId = :taskId ");
    	$stmt->bindParam(':taskId', $taskId);
    	$stmt->bindParam(':status', $status);
    	$stmt->execute();
	}

	header('Location:' . 'display.php');
    exit();
?>