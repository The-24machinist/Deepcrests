<?php
require 'config/config.php';
include("includes/classes/Post.php");
?>


	<?php


if(isset($_POST['theidmanfool'])){

	$thebody=$_POST['edititman'];	
	$theidbro=$_POST['theidmanfool'];
	echo "$theidbro";
	$mine=mysqli_query($con,"UPDATE posts SET body='$thebody' WHERE id='$theidbro' ");
	
}
	?>

