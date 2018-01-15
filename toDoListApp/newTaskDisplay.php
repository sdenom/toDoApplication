<!DOCTYPE html>
<style>
	input {
    width: 50%;
}
	textarea {
    width: 50%;
    padding-bottom: 50px;
}
</style>
<html lang="en">


<?php

	$listId = $_GET['listId'];
	$listTitle = $_GET['listTitle'];
	
	echo "<h4>New task for " . $listTitle . "</h4>";

?>



<title>display</title> </head>
<body>
<form action = "newTaskPost.php" method="post">
	<div class="form-group">

<input type = "text" required placeholder="Enter title" name="title">
<textarea cols="40" rows="5" requried placeholder="Enter description" name="description"></textarea>
<input type = "date" required name="dueDate">
<input type = "hidden" value="<?php echo $listId ?>" name="listId">
<input type = "submit" value = "Submit">
</div>
</form>
</body>
</html>