<?php  
include("includes/header.php");

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	$id = 0;
}

if(isset($_SESSION['username'])){

}
else{

}
?>

<link rel="stylesheet" type="text/css" href="styling.css">



	<div class="main_column column" id="main_column">

		<div class="posts_area">

			<?php 
				$post = new Post($con, $userLoggedIn);
				$post->getSinglePost($id);
			?>

		</div>

	</div>