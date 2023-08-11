<?php

include("includes/header.php");

if(isset($_GET['q'])) {
	$query = $_GET['q'];
}
else {
	$query = "";
}

if(isset($_GET['type'])) {
	$type = $_GET['type'];
}
else {
	$type = "name";
}

$sqliet="SELECT college FROM users WHERE username='$userLoggedIn'";

		$resultiet=$con->query($sqliet);

		if($resultiet->num_rows>0){
			while($rowiet=$resultiet->fetch_assoc()){
$collegename=$rowiet['college'];
			}
		}




?>

<div class="main_column column" id="main_column">

	<?php 
	if($query == "")
		echo "You must enter something in the search box.";
	else {
		

		//If query contains an underscore, assume user is searching for usernames
		if($type == "username") {
			$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE college='$collegename' AND username LIKE '$query%' AND user_closed='no' LIMIT 8");
		}
		//If there are two words, assume they are first and last names respectively

		else {

			$names = explode(" ", $query);

			if(count($names) == 3)
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[2]%') AND user_closed='no'");
			//If query has one word only, search first names or last names 
			else if(count($names) == 2)
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE college='$collegename' AND (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no'");
			else 
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE college='$collegename' AND (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no'");
		}
		if(mysqli_num_rows($usersReturnedQuery) == 0)
			echo "There is no one with the name " .$query;
		else 
			echo " results found:".mysqli_num_rows($usersReturnedQuery)." <br> <br>";


//searching for the users with their name and username thingy

		while($row = mysqli_fetch_array($usersReturnedQuery)) {
			$user_obj = new User($con, $user['username']);

			$button = "";
			$mutual_friends = "";

			if($user['username'] != $row['username']) {

				//Generate button depending on friendship status 
				if($user_obj->isFriend($row['username']))
					$button = "<input type='submit' name='" . $row['username'] . "' class='danger' value='Unfollow'>";
				else if($user_obj->didReceiveRequest($row['username']))
					$button = "<input type='submit' name='" . $row['username'] . "' class='warning' value='Respond to request'>";
				else if($user_obj->didSendRequest($row['username']))
					$button = "<input type='submit' class='default' value='Request Sent'>";
				else 
					$button = "<input type='submit' name='" . $row['username'] . "' class='success' value='Follow'>";

				//$mutual_friends = $user_obj->getMutualFriends($row['username']) . " friends in common";


				//Button forms
				if(isset($_POST[$row['username']])) {

					if($user_obj->isFriend($row['username'])) {
						$user_obj->removeFriend($row['username']);
						header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
					}
					else if($user_obj->didReceiveRequest($row['username'])) {
						header("Location: requests.php");
					}
					else if($user_obj->didSendRequest($row['username'])) {

					}
					else {
						$user_obj->sendRequest($row['username']);
						header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
					}

				}



			}

			echo "<div class='search_result'>
					<div class='searchPageFriendButtons'>
						<form action='' method='POST'>
							" . $button . "
							<br>
						</form>
					</div>



						<a href='" . $row['username'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
						<p id='grey'> " . $row['username'] ."</p>
						</a>
						<br>
						<br>

				</div>
				<hr id='search_hr'>";

		} //End while of searching for the usernmaes of the goddamnn thing












		$conn=new mysqli('localhost','root','','social');
		if($conn->connect_error){
			die("connection failed:".$conn->connect_error);
		}


		$sql="SELECT id,tags,body,added_by,heading FROM posts WHERE college='$collegename'";
		$result=$conn->query($sql);

		if($result->num_rows>0){
			$count=0;
			while($row=$result->fetch_assoc()){
				$thing=explode(", ",$row['tags']);
                $fuss=trim($row['heading']);
				$fellout=preg_match("/".$query."/",$fuss);
				

				foreach ($thing as $key) {
					$fell=preg_match("/".$query."/", $key);
					if($fell==1){
						$check=1;
						break;
					}
					else{
						$check=0;
					}
				}
				if($check==1||$fellout==1){
$count=$count+1;
///set the limit here bro down
$thelimit=2;
if($count>$thelimit){
   break;
}
$thingf= explode(",", $row['tags']);
					$suck="";
					foreach ($thingf as $yep) {
						$sucks=trim($yep);
						$suck.="<a id='tagssy' href='search.php?q=".$sucks."'>".$yep."</a>";
}
					echo "<div class='status_post'>					
								<div class='posted_by' style='color:#ACACAC;'>
									<a href='".$row['added_by']."'>".$row['added_by']."</a>  
								</div>
								<div id='post_body'>
								<a href='post.php?id=".$row['id']."'><h1>".$row['heading']."</h1>
									<h3 id='thepara'>".$row['body']."</h3>
									$suck
									<br>
									<br>
									<br>
									</a>
								</div>

								<div class='newsfeedPostOptions'>
									
									<iframe src='like.php?post_id=".$row['id']."' scrolling='no'></iframe>
								</div>

							</div>
							<div class='post_comment' id='toggleComment".$row['id']."' style='display:none;'>
								<iframe src='comment_frame.php?post_id=".$row['id']."' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<br>
							<br>";
				}				
			}

			//if($count>$thelimit){
			//	echo "if your searching for something particular, then type it down properly motherfucking ass fucking ass fuckers";
			//}
		}


		//Check if results were found 
		



		
	}


	?>



</div>