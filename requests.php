<?php
include("includes/header.php"); //Header 



?>

<style type="text/css">
	::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent */
}
</style>






<div class="main_column column" id="main_column">

	<h4 style="color: white;">Allow your motherfucking followers</h4>

	<?php  

	$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");
	if(mysqli_num_rows($query) == 0)
		echo "You have no motherfuckers to follow you ";
	else {

		while($row = mysqli_fetch_array($query)) {
			$user_from = $row['user_from'];
			$user_from_obj = new User($con, $user_from);
			$user_to=$row['user_to'];

			echo $user_from_obj->getFirstAndLastName() . " wants to motherfucking follow you !";

			$user_from_friend_array = $user_from_obj->getFriendArray();

			if(isset($_POST['accept_request' . $user_from ])) {
				//$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userLoggedIn'");
				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,')  WHERE username='$user_from'");

				$followery=mysqli_query($con,"UPDATE users SET followers=CONCAT(followers,'$user_from,') WHERE username='$user_to'");

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
				echo "following you";
				header("Location: requests.php");
			}

			if(isset($_POST['ignore_request' . $user_from ])) {
				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
				echo "Request ignored!";
				header("Location: requests.php");
			}

			?>
			<form action="requests.php" method="POST">
				<input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="Accept">
				<input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Fuck it ">
			</form>
			<?php


		}

	}

	?>


</div>

<div id="thefollowersbuddy" class='followerslist'>
	<h1 style="color: black;">Followers</h1>
	<?php
	$quert=mysqli_query($con,"SELECT followers,profile_pic FROM users WHERE username='$userLoggedIn'");
while ($rowy=mysqli_fetch_array($quert)) {
	$moner=$rowy['followers'];
	
	$monert=explode(",", "$moner");
	$thecounter=count($monert)-1;
	echo "<p style='color:black;'>Followers:".$thecounter."</p>";
	/*$monerty=array_splice($monert, 1,-1);
	foreach ($monert as $keyer) {

		echo "<a id='thefollower' href='".$keyer."'>
		".$keyer."
		</a>";
		echo "<br>";
		echo "<br>";
	}
	*/

	echo "<p id='thefollower'>".$moner."</p>";
}
	?>
</div>
<br>

<div id="thefollowersbud" class='followersli'>
	<h1 style="color: black;">Following</h1>
	<?php
	$quert=mysqli_query($con,"SELECT friend_array,followers,profile_pic FROM users WHERE username='$userLoggedIn'");
while ($rowy=mysqli_fetch_array($quert)) {
	$moner=$rowy['friend_array'];
	
	$monert=explode(",", "$moner");
	$thecounter=count($monert)-1;
	echo "<p style='color:black;'>Following:".$thecounter."</p>";
	/*$monerty=array_splice($monert, 1,-1);
	foreach ($monerty as $keyer) {

		echo "<a id='thefollower' href='".$keyer."'>
		".$keyer."
		</a>";
		echo "<br>";
		echo "<br>";
	}
	*/

	echo "<p id='thefollower'>".$moner."</p>";
}
	?>
</div>