<?php

include("includes/header.php");
include("personality_loader.php");


?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Personality</title>

	<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</head>
<body>




	<form action="personality.php" method="POST">
		<input type="text" name="personality1" value="">
		<input type="text" name="personality2" value="">
		<input type="text" name="personality3" value="">
		<input type="text" name="personality4" value="">
		<input type="text" name="personality5" value="">
<?php
$usernamthing=$_SESSION['username'];
$check_personali = mysqli_query($con, "SELECT username FROM personality WHERE username='$usernamthing'");
if(mysqli_num_rows($check_personali) == 0){
echo "<input type='submit' name='personalitysubmit' value='Create mine'>";

}
else{
	echo "<input type='submit' name='personalitysubmit' value='Update it'>";
}

?>


	</form>

</body>
</html>