<!DOCTYPE html>
<html lang="en">
<body>
	<?php
		$dbc = mysqli_connect('localhost:5507', 'root', 'phpbook', 'sample') or die("Connect Error");

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
			$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
			$job = mysqli_real_escape_string($dbc, trim($_POST['job']));
			$mgr = mysqli_real_escape_string($dbc, trim($_POST['mgr']));
			$sal = mysqli_real_escape_string($dbc, trim($_POST['sal']));
			$commission = mysqli_real_escape_string($dbc, trim($_POST['commission']));
			$department = mysqli_real_escape_string($dbc, trim($_POST['department']));
			$phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));

			$query = "insert into sample.emp values (NULL,'$name','$email','$password','$job',$mgr, CURDATE(),$sal,$commission,$department,'$phone')";

			$result = mysqli_query($dbc, $query) or die("error");

			$_COOKIE('username',$name,time()+3600, '/');
			$_COOKIE('userjob',$job,time()+3600, '/');

			header('location:'.'../client/post.html');
		}
	?>
</body>
</html>