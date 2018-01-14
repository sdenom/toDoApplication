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

class Person {
	public $userId = 0;
	public $username = "";
	public $lists = getLists();


}

public function getLists()
{
	$taskA = new Task();
	$taskB = new Task();
	$taskA->$taskId = 1;
	$taskA->$title = "Sample task A";
	$taskA->$description = "The quick brown fox jumps over the lazy dog";
	$taskA->$date = "08/19/2018";
	$taskA->$status = "Pending";
	$taskB->$taskId = 2;
	$taskB->$title = "Sample task B";
	$taskB->$description = "The quick brown fox jumps over the lazy dog";
	$taskB->$date = "11/05/2017";
	$taskB->$status = "Late";

	$newList = new TaskList();
	$newList->$tasks = array($taskA, $taskB);
	$newList->$title = "Sample title";

	return array($newList);
}

?>