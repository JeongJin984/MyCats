<!DOCTYPE html>
<html lang="en">
<body>
		<?php
			$dbc = mysqli_connect('localhost:5507', 'root', 'phpbook', 'sample') or die("Connect Error");

			if($_SERVER["REQUEST_METHOD"] == "POST") {
				$empId = mysqli_real_escape_string($dbc, trim($_POST['id']));
				$empPassword = mysqli_real_escape_string($dbc, trim($_POST['password']));

				$query = "select * from sample.emp where EMAIL = '$empId' AND PASSWORD = '$empPassword'";
				$result = mysqli_query($dbc, $query) or die("error");
			}

			$row = mysqli_fetch_assoc($result);

			if($row['ENAME']) {
				setcookie('userid', $row['EMPNO'], time()+3600, '/');
				setcookie('username',$row['ENAME'], time()+3600, '/');
				setcookie('userjob',$row['JOB'], time()+3600, '/');
				header('location:'.'../client/post.html');
			} else {
				echo "login error";
			}			

			mysqli_free_result($result);
			mysqli_close($dbc);
		?>
</body>
</html>