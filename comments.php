<!-- Load comments -->
	<?php  

class comments{

private $user_obj;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	public function loadthecomments($data, $limit){


$post_id=$data;

$num_iterations = 0; //Number of messages checked 
		$counts = 1; //Number of messages posted
$return_string = "not there";

		$get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
	$count = mysqli_num_rows($get_comments);

	if($count != 0) {

		while($comment = mysqli_fetch_array($get_comments)) {

			if($num_iterations++ < $start)
				continue;

			if($counts > $limit)
				break;
			else 
				$counts++;


			$comment_body = $comment['post_body'];
			$posted_to = $comment['posted_to'];
			$posted_by = $comment['posted_by'];
			$date_added = $comment['date_added'];
			$removed = $comment['removed'];
			$poster=$comment['id'];

			//Timeframe
			$date_time_now = date("Y-m-d H:i:s");
			$start_date = new DateTime($date_added); //Time of post
			$end_date = new DateTime($date_time_now); //Current time
			$interval = $start_date->diff($end_date); //Difference between dates 
			if($interval->y >= 1) {
				if($interval == 1)
					$time_message = $interval->y . " year ago"; //1 year ago
				else 
					$time_message = $interval->y . " years ago"; //1+ year ago
			}
			else if ($interval->m >= 1) {
				if($interval->d == 0) {
					$days = " ago";
				}
				else if($interval->d == 1) {
					$days = $interval->d . " day ago";
				}
				else {
					$days = $interval->d . " days ago";
				}


				if($interval->m == 1) {
					$time_message = $interval->m . " month". $days;
				}
				else {
					$time_message = $interval->m . " months". $days;
				}

			}
			else if($interval->d >= 1) {
				if($interval->d == 1) {
					$time_message = "Yesterday";
				}
				else {
					$time_message = $interval->d . " days ago";
				}
			}
			else if($interval->h >= 1) {
				if($interval->h == 1) {
					$time_message = $interval->h . " hour ago";
				}
				else {
					$time_message = $interval->h . " hours ago";
				}
			}
			else if($interval->i >= 1) {
				if($interval->i == 1) {
					$time_message = $interval->i . " minute ago";
				}
				else {
					$time_message = $interval->i . " minutes ago";
				}
			}
			else {
				if($interval->s < 30) {
					$time_message = "Just now";
				}
				else {
					$time_message = $interval->s . " seconds ago";
				}
			}

			$user_obj = new User($con, $posted_by);


			?>

			<?php
			$return_string.="<div class='comment_section'>
				
				<a id='thenamery' href="echo $posted_by;" target='_parent'> <b>"echo $user_obj->getFirstAndLastName();" ?> </b></a>
				&nbsp;&nbsp;&nbsp;&nbsp;"echo $time_message . "<br><p>" . $comment_body;" </p>";

			?>
				<?php
				if($userLoggedIn==$posted_by){
					 $return_string .="<form id='delco' method='POST' action='comment_frame.php?post_id=$post_id?>' name='delco'> 
					<input type='hidden' value='".$post_id." name='post_id' >'
					       <input type='hidden' value='".$poster."' name='delcom'>
					 <button type='submit' style='float: left;'>Delete</button>
					 </form>";
				}
				?>
				
				<hr>
			</div>
			<?php


if($counts > $limit)
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='I don't know man><input type='hidden' class='noMoreDropdownData' value='false'>";
		else 
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'> <p style='text-align: center;'>Nothing more</p>";

		return $return_string;
		}
	}
	else {
		echo "<center style='color:white;'><br><br><b>comment any bullshit</b></center>";
	}

	}


	
}


	?>




