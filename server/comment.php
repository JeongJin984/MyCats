<?php
	header("Content-Type: application/json");
	$dbc = mysqli_connect('localhost:5507', 'root', 'phpbook', 'sample') or die("Connect Error");

	$postid = $_GET['postid'];

	$comment = '';
	$comment = mysqli_real_escape_string($dbc, trim($_POST['comment']));
	$username = $_COOKIE['username'];

	$query = "insert into sample.comment values (NULL, $postid,'$comment','$username')";
	mysqli_query($dbc, $query) or die("error");
	
	echo json_encode(['comment' => $comment]);

	mysqli_free_result($result);
	mysqli_close($dbc);

?>