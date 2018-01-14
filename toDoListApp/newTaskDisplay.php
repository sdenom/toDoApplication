<!DOCTYPE html>

<?php

	$listId = 3;
	
?>

<html lang="en">


<title>display</title> </head>
<body>
<form action = "newTaskPost.php" method="post">

<input type = "text" placeholder="Enter title" name="title">
<input type = "text" placeholder="Enter description" name="description">
<input type = "datetime" name="dueDate">
<input type = "hidden" value="<?php echo $listId ?>" name="listId">
<input type = "submit" value = "Submit">

</form>
</body>
</html>