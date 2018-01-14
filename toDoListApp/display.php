<!DOCTYPE html>
<html lang="en"> <head>
<meta charset="utf-8">
<title>display</title> </head>
<body>

<a href = "newListDisplay.php"> Add New List </a>

<p>
	<?php

		$userA = new User();
		$userA->lists = getLists();
		foreach ($userA->lists as $list)
		{

			echo $list->title . "</br>";
			foreach ($list->tasks as $task)
			{
				echo $task->title . "</br>";
			}
			echo "<a href = 'newTaskDisplay.php?listId=" . $list->listId . "'> Add New Task </a>";
			echo "</br>";
		}
	?>
</p>

</body>
</html>


<?php
class Task {
	public $taskId = 0;
	public $title = "";
	public $description = "";
	public $date = "";
	public $status = "";
}

class TaskList {
	public $listId = 0;
	public $title = "";
	public $tasks = array();

}

class User {
	public $userId = 0;
	public $username = "";
	public $lists;

}

function displayLists()
{
	$connection = new PDO("mysql:dbname=todo;host=localhost:3306", 'root', 'password123');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = 1;
    $stmt = $connection->prepare("SELECT * FROM tasklist WHERE userId = :userId");
	$stmt->bindParam(':userId', $userId);
	$stmt->execute();

	$result = $stmt->fetchAll();

	print_r($result);

}



function getLists()
{

	$connection = new PDO("mysql:dbname=todo;host=localhost:3306", 'root', 'password123');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = 1;
    $stmt = $connection->prepare("SELECT * FROM tasklist WHERE userId = :userId");
	$stmt->bindParam(':userId', $userId);
	$stmt->execute();

	$result = $stmt->fetchAll();

	$lists = array();
	foreach ($result as $rowIndex => $row) {
		$list = new TaskList();
		$list->title = $row['title'];
		$list->tasks = getTasks($row['listId']);
		$list->listId = $row['listId'];
		$lists[] = $list;
	}
	return $lists;
}

function getTasks($listId)
{

	$connection = new PDO("mysql:dbname=todo;host=localhost:3306", 'root', 'password123');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = 1;
    $stmt = $connection->prepare("SELECT * FROM task WHERE listId = :listId");
	$stmt->bindParam(':listId', $listId);
	$stmt->execute();

	$result = $stmt->fetchAll();

	$tasks = array();
	foreach ($result as $rowIndex => $row) {
		$task = new TaskList();
		$task->title = $row['title'];
		$task->description = $row['description'];
		$task->date = $row['dueDate'];
		$task->status = $row['status'];
		$tasks[] = $task;
	}
	return $tasks;
}

?>