<?php
	header("Content-Type: application/json");
	$dbc = mysqli_connect('localhost:5507', 'root', 'phpbook', 'sample') or die("Connect Error");

	$target_dir = 'image/';
	$target_file = $target_dir . basename($_FILES["postImage"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	date_default_timezone_set("America/New_York");
	$temp = date('m_d_Y_s') . basename($_FILES["postImage"]["name"]);
	$new_target_file = $target_dir . $temp;

	$curid = $_COOKIE['userid'];
	$curuser = $_COOKIE['username'];

	$arr = array();

	if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $new_target_file)) {
		$query = "insert into sample.post values (NULL, '$temp', $curid,'$curuser')";
		mysqli_query($dbc,$query);
		
		$query = "select * from sample.post where photo='$temp'";
		$result = mysqli_query($dbc,$query) or die("query error");

		$row = mysqli_fetch_assoc($result);
		$obj = ['writer' => $row['poster'], 'imagePath' => $row['photo'], 'id' => $row['id']];
		
		echo json_encode($obj);
	}	else {
		$query = "select * from sample.post";
		$result = mysqli_query($dbc,$query) or die("query error");
	
		while($row = mysqli_fetch_assoc($result)) {
			$obj = ['writer' => $row['poster'], 'imagePath' => $row['photo'], 'id' => $row['id']];
			$JSONobj = json_encode($obj);
			array_push($arr, $JSONobj);
		}
	
		echo json_encode($arr);
	}

	mysqli_free_result($result);
	mysqli_close($dbc);
?>