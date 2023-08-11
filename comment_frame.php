<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>

	<style type="text/css">
	* {
		font-size: 12px;
		font-family: Arial, Helvetica, Sans-serif;
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
	}
	else {
		header("Location: register.php");
	}

	?>
	<script>
		function toggle() {
			var element = document.getElementById("comment_section");

			if(element.style.display == "block") {

				element.style.display = "none";
				console.log("this is the thing on earth I guess");
			}
			else {
				element.style.display = "block";
			}
		}
	</script>

	<script type="text/javascript">
		//startfromhere=0;
		var thestuff=0;
function loadthecomments(){
var postid=document.getElementById("postid").value;
var limity=3;


thestuff+=limity;
var getdiv=document.getElementById("commentinside");
	$.ajax({

     url : 'includes/handlers/ajax_load_comments.php',
     type : 'POST',
     data: {posty: postid, limit: limity, max: thestuff},
     success : function (result) {
       // console.log (result); // Here, you need to use response by PHP file.
        
        getdiv.innerHTML=result.toString();

     },
     error : function (request, status, error) {
        console.log (request.responseText);
         
     }

   });
}

	</script>

	<?php  
	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
		echo "<input type='hidden' id='postid' value='".$post_id."'>";
		if(isset($_POST['delcom'])){
		$thinger=$_POST['delcom'];
		echo "reached here";
		$sqlbud=mysqli_query($con, "DELETE FROM comments WHERE id='$thinger'");

	}
	}



	$user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($user_query);

	$posted_to = $row['added_by'];
	$user_to = $row['user_to'];

	if(isset($_POST['postComment' . $post_id])) {
		$post_body = $_POST['post_body'];
		$post_body = mysqli_escape_string($con, $post_body);
		$date_time_now = date("Y-m-d H:i:s");
		$insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");

		if($posted_to != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $posted_to, "comment");
		}
		
		if($user_to != 'none' && $user_to != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $user_to, "profile_comment");
		}


		$get_commenters = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id'");
		$notified_users = array();
		while($row = mysqli_fetch_array($get_commenters)) {

			if($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to 
				&& $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)) {

				$notification = new Notification($con, $userLoggedIn);
				$notification->insertNotification($post_id, $row['posted_by'], "comment_non_owner");

				array_push($notified_users, $row['posted_by']);
			}

		}


		
	}
	?>
	<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST">
		<textarea style="resize: none;" name="post_body"></textarea>
		<input style="background-color: white;cursor: pointer;" type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
	</form>

	<!-- Load comments -->
	<div id="commentinside">
		<button id="commentloader" onclick="loadthecomments()">Load the comments nigger</button>

	</div>




</body>
</html>