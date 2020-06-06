<?php
	header("Content-Type: application/json");
	$dbc = mysqli_connect('localhost:5507', 'root', 'phpbook', 'sample') or die("Connect Error");

	if(!$_GET['postid']){
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
		$commArr = array();
	
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
				$postid = $row['id'];
	
				$query2 = "select * from sample.post left join sample.comment on sample.post.id = sample.comment.postid where postid=$postid";
				$result2 = mysqli_query($dbc,$query2) or die("query error");
				
				$commArr = [];
				while($row2 = mysqli_fetch_assoc($result2)) {
					$obj2 = ['writer' => $row2['writer'], 'comment' => $row2['comment']];
					$JSONobj2 = json_encode($obj2);
	
					array_push($commArr, $JSONobj2);
				}
				mysqli_free_result($result2);

				$obj = ['writer' => $row['poster'], 'imagePath' => $row['photo'], 'id' => $row['id'], 'comment' => json_encode($commArr)];
				$JSONobj = json_encode($obj);
				array_push($arr, $JSONobj);
			}

			mysqli_free_result($result);
			echo json_encode($arr);
			$commArr = array();
		}
	} else {
		$postid = $_GET['postid'];

		$comment = mysqli_real_escape_string($dbc, trim($_POST['comment']));
		$username = $_COOKIE['username'];
	
		$query = "insert into sample.comment values (NULL, $postid,'$comment','$username')";
		mysqli_query($dbc, $query) or die("error");

		$obj3 = ['writer' => $username, 'comment' => $comment];
		echo json_encode($obj3);
	}
	mysqli_close($dbc);
?>
