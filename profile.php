<?php 
include("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if(isset($_GET['profile_username'])) {
	$username = $_GET['profile_username'];
	//$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	//$user_array = mysqli_fetch_array($user_details_query);

	//$num_friends = (substr_count($user_array['friend_array'], ",")) ;
}



if(isset($_POST['remove_friend'])) {
	$user = new User($con, $userLoggedIn);
	$user->removeFriend($username);
}

if(isset($_POST['requestsent'])){
  $user = new User($con, $userLoggedIn);
  $user->RemoveRequest($username);
}

if(isset($_POST['add_friend'])) {
	$user = new User($con, $userLoggedIn);
	$user->sendRequest($username);
}
if(isset($_POST['respond_request'])) {
	header("Location: requests.php");
}

if(isset($_POST['post_message'])) {
  if(isset($_POST['message_body'])) {
    $body = mysqli_real_escape_string($con, $_POST['message_body']);
    $date = date("Y-m-d H:i:s");
    $message_obj->sendMessage($username, $body, $date);
  }

  $link = '#profileTabs a[href="#messages_div"]';
  echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";


}

 ?>



	
 	<div class="profile_left">
 		<div class="profile_info" style="border-radius: 20px; ">
      <h2 style="padding: 10px; word-wrap: break-word;"><?php  echo $username;   ?></h2>
 			<!--<p><?php echo "Posts: " . $user_array['num_posts']; ?></p>-->
 			<!--<p><?php //echo "Likes: " . $user_array['num_likes']; ?></p>
 			<p><?php //echo "Friends: " . $num_friends ?></p>-->

<?php

$get_pers = mysqli_query($con, "SELECT * FROM personality WHERE username='$username'");
while($pers = mysqli_fetch_array($get_pers)) {

  echo "<br>".$pers['first']."<br>";
  echo "<br>".$pers['second']."<br>";
  echo "<br>".$pers['third']."<br>";
  echo "<br>".$pers['fourth']."<br>";
  echo "<br>".$pers['fifth']."<br>";

  }

?>


 		</div>



<script type="text/javascript">
  function formchecker(){
    var form = document.getElementById("thesubmitform");
form.submit();
  }
</script>


<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>



 		<form id="thesubmitform" action="<?php echo $username; ?>" method="POST">
 			<?php 
 			$profile_user_obj = new User($con, $username); 
 			if($profile_user_obj->isClosed()) {
 				header("Location: user_closed.php");
 			}

 			$logged_in_user_obj = new User($con, $userLoggedIn); 

 			if($userLoggedIn != $username) {

 				if($logged_in_user_obj->isFriend($username)) {
 					echo '<input type="hidden" name="remove_friend" class="danger" value="Unfollow"><br>';
          echo '<button onclick="formchecker()">Unfollow</button>';
 				}
 				else if ($logged_in_user_obj->didReceiveRequest($username)) {
 					echo '<input type="hidden" name="respond_request" class="warning" value="Wants to follow"><br>';
          echo '<button onclick="formchecker()">Wants to follow</button>';
 				}
 				else if ($logged_in_user_obj->didSendRequest($username)) {
 					echo '<input type="hidden" name="requestsent" class="default" value="Request Sent"><br>';
          echo '<button onclick="formchecker()">Request sent</button>';
 				}
 				else {
 					echo '<input type="hidden" name="add_friend" class="success" value="Follow this nigger"><br>';
        
        echo '<button onclick="formchecker()">Follow this nigger</button>';
}
 			}

 			?>
 		</form>
 		<!--<input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post Something">-->

  <?php  
    if($userLoggedIn == $username) {

     // echo '<input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Upload it">';
    }


    ?>

 	</div>

<!--<input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Upload it">-->


	<div class="profile_main_column column">

  <!--  <ul class="nav nav-tabs" role="tablist" id="profileTabs">
      <li role="presentation" class="active"><a href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a></li>
      
    </ul>
-->
    <div class="tab-content">

      <div role="tabpanel" class="tab-pane fade in active" id="newsfeed_div">
        <div class="posts_area"></div>
        <img id="loading" src="assets/images/icons/loading.gif">
      </div>


      <div role="tabpanel" class="tab-pane fade" id="messages_div">
        <?php  
        

          echo "<h4>You and <a href='" . $username ."'>" . $profile_user_obj->getFirstAndLastName() . "</a></h4><hr><br>";

          echo "<div class='loaded_messages' id='scroll_messages'>";
            echo $message_obj->getMessages($username);
          echo "</div>";
        ?>



        <div class="message_post">
          <form action="" method="POST">
              <textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>
              <input type='submit' name='post_message' class='info' id='message_submit' value='Send'>
          </form>

        </div>

        <script>
          var div = document.getElementById("scroll_messages");
          div.scrollTop = div.scrollHeight;
        </script>
      </div>


    </div>


	</div>



	
</body>
</html>