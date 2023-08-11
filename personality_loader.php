<?php

if(isset($_POST['personalitysubmit'])){
	$personality1=$_POST['personality1'];
	$personality2=$_POST['personality2'];
	$personality3=$_POST['personality3'];
	$personality4=$_POST['personality4'];
	$personality5=$_POST['personality5'];
$userthing=$_SESSION['username'];
$check_personality = mysqli_query($con, "SELECT username FROM personality WHERE username='$userthing'");

$collegething = mysqli_query($con, "SELECT college FROM users WHERE username='$userthing'");
$colleger = mysqli_fetch_array($collegething);
$collegenamething=$colleger['college'];

if(mysqli_num_rows($check_personality) == 0){
     $query = mysqli_query($con, "INSERT INTO personality VALUES ('', '$userthing', '$collegenamething','$personality1', '$personality2', '$personality3','$personality4','$personality5')");
     echo "Inserted successfully";
}
else{
	$query = mysqli_query($con, "UPDATE personality SET first='$personality1', second='$personality2', third='$personality3', fourth='$personality4', fifth='$personality5' WHERE username='$userthing'");
	echo "Updated successfully";
}

}

?>