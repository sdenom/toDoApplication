<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<head>
<meta charset="utf-8">
<title>display</title>
</head>
<body>



<p>
	<?php

	

	$userId = $_SESSION['userId'];

	echo "<form action='newListDisplay.php?userId=" .  $userId ."' >
			<input type='submit' value='Add New List'/>
		 </form>";

		displayStatusHeader();
		$userA = new User();
		$userA->lists = getLists();

		echo "<hr>";

		foreach ($userA->lists as $list)
		{

			echo "<b><u>" . $list->title . "</b></u><pre>" . "<a href = 'deleteList.php?listId=" .  $list->listId ."''>Delete List</a></pre></br>";
			echo "<table>
					<thead>
						<tr>
							<th>Task Title</th>
							<th>Description</th>
							<th>Due Date</th>
							<th>Status</th>
							<th>Start Task</th>
							<th>Complete Task</th>
							<th>Delete Task</th>
						</tr>
					</thead>
					<tbody>";
			foreach ($list->tasks as $task)
			{
				$htmlDescription = preg_replace("/\r\n|\r|\n/",'<br/>', $task->description);
				
				echo "<tr>
				<td>" . $task->title . "</td>" .
				"<td>" . $htmlDescription . "</td>" .
				"<td>" . $task->dueDate . "</td>" .
				"<td>" . $task->status . "</td>" .
				"<td>" . "<a href = 'updateTask.php?status=Started&taskId=". $task->taskId ."'>Start</a>" . "</td>" .
				"<td>" . "<a href = 'updateTask.php?status=Completed&taskId=". $task->taskId ."'>Complete</a>" . "</td>" .
				"<td>" . "<a href = 'updateTask.php?status=Deleted&taskId=". $task->taskId ."'>Delete</a>" . "</td>" .
				"</tr>";
			}
			
			echo "</tbody></table>";
			echo "</br>";
			echo "<a href = 'newTaskDisplay.php?listId=" . $list->listId . "&listTitle=" . $list->title . "'> Add New Task </a>";
			echo "</br>";
			echo "<hr>";
		}
	?>
</p>
<p align='right'>
	<a href='logout.php'>Logout</a>
</p>
</body>
</html>


<?php

class Task {
	public $taskId = 0;
	public $title = "";
	public $description = "";
	public $dueDate = "";
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
	public $password = "";
	public $lists;

}


function getLists()
{
    $userId = $_SESSION["userId"];

	$db = parse_ini_file("connection.ini");
	$connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    $userId = $_SESSION["userId"];

	$db = parse_ini_file("connection.ini");
	$connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("UPDATE task SET status = 'Late' WHERE status <> 'Completed' AND dueDate < CURDATE()");
    $stmt->execute();

    $where = " WHERE listId = :listId";

    if (isset($_GET['filter']))
    {

    	$where .= " AND status = :status";

    }


    $stmt = $connection->prepare("SELECT * FROM task" . $where . " ORDER BY status");
	$stmt->bindParam(':listId', $listId);

	if (isset($_GET['filter']))
    {
    	$stmt->bindParam(':status', $status);
    	$status = $_GET['filter'];
    }

	$stmt->execute();

	$result = $stmt->fetchAll();

	$tasks = array();
	foreach ($result as $rowIndex => $row) 
	{
		$task = new TaskList();
		$task->title = $row['title'];
		$task->taskId = $row['taskId'];
		$task->description = $row['description'];
		$task->dueDate = $row['dueDate'];
		$task->status = $row['status'];
		$tasks[] = $task;
	}
	return $tasks;
}
function displayStatusHeader()
{
    $userId = $_SESSION["userId"];

	$db = parse_ini_file("connection.ini");
	$connection = new PDO($db['type'] . ":dbname=" . $db['name'] . ";host=" . $db['host'], $db['user'], $db['password']);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("UPDATE task SET status = 'Late' WHERE status <> 'Completed' AND dueDate < CURDATE()");
    $stmt->execute();



    $stmt = $connection->prepare("SELECT task.status, COUNT(*) AS 'statusCount' FROM task 
    								JOIN taskList ON task.listId = taskList.listId 
    								WHERE taskList.userId = :userId GROUP BY status");
	$stmt->bindParam(':userId', $userId);

	$stmt->execute();

	$result = $stmt->fetchAll();

	$total = 0;

	foreach($result as $rowIndex => $row)
	{
		$total += $row['statusCount'];
	}

	echo "<a href='display.php'>All (" . $total . ")</a></br>";

	foreach($result as $rowIndex => $row)
	{
		echo "<a href='display.php?filter=" . $row['status'] . "'>" . $row['status'] . " (" . $row['statusCount'] . ")</a></br>";
	}

}

?>