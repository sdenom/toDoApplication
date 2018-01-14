<!DOCTYPE html>

<?php

	$userId = 1;
	
?>

<html lang="en">


<title>display</title> </head>
<body>
<form action = "newListPost.php" method="post">

<input type = "text" value="Enter title" name="listTitle">
<input type = "hidden" value="<?php echo $userId ?>" name="userId">
<input type = "submit" value = "Submit">

</form>
</body>
</html>