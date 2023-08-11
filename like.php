<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>

	<style type="text/css">

	* {
		font-family: Arial, Helvetica, Sans-serif;
	}
	body {
		background: transparent;
		height: fit-content;
	}

	form {
		position: absolute;
		top: 0;
		right: 25px;
	}

#totallikes{
	float: right;
	color: yellow;
}


	</style>

	<?php  
	require 'config/config.php';
	include("includes/classes/User.php");
	include("includes/classes/Post.php");
	include("includes/classes/Notification.php");

	if (isset($_SESSION['username'])) {
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
		$user = mysqli_fetch_array($user_details_query);
		$usernum=$user['id'];
	}
	else {
		header("Location: register.php");
	}

	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['likes']; 
	$user_liked = $row['added_by'];

	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
	$row = mysqli_fetch_array($user_details_query);
	$total_user_likes = $row['num_likes'];

	//Like button
	if(isset($_POST['like_button'])) {
		$total_likes++;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes++;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
		$insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$usernum', '$post_id')");

		//Insert Notification
		if($user_liked != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $user_liked, "like");
		}
	}
	//Unlike button
	if(isset($_POST['unlike_button'])) {
		$total_likes--;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes--;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
		$insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$usernum' AND post_id='$post_id'");
	}

	//Check for previous likes
	$check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$usernum' AND post_id='$post_id'");
	$num_rows = mysqli_num_rows($check_query);

	if($num_rows > 0) {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
				<button id="likesucker" style="background:transparent;" type="submit" class="comment_like" name="unlike_button" value="Unlike"><i class="fa fa-thumbs-up" style="font-size:35px; color:red;"></i></button>

				
				
			</form>
			<br>
			<br>
			<p id="totallikes">'. $total_likes .' Liked</p>
		';
	}
	else {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
				<button id="likesucker" style="background:transparent;" type="submit" class="comment_like" name="like_button" value="Like">
					<i class="fa fa-thumbs-up" style="font-size:35px; color:white;"></i>
				</button>

				
				
			</form>
			<br>
			<br>
			<p id="totallikes">'. $total_likes .' Liked</p>
		';
	}


	?>




</body>
</html>