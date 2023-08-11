<?php
include("config/config.php");
include("includes/classes/User.php");


if(isset($_POST['stuff']))
{
	$typed=$_POST['stuff'];
	$collegename=$_POST['college'];



$usersReturne = mysqli_query($con, "SELECT DISTINCT * FROM personality WHERE (first LIKE '%$typed%' OR second LIKE '%$typed%' OR third LIKE '%$typed%' OR fourth LIKE '%$typed%' OR fifth LIKE '%$typed%') AND college='$collegename' LIMIT 4");



while($row = mysqli_fetch_array($usersReturne)) {
echo "<div id='containtags'>";
	if($typed){


	echo "<a id='taggername' target='_parent' href=".$row['username'].">".$row['username']."</a><br>";


	if(str_contains($row['first'], $typed)){
      echo "<label id='thetags' onclick='checker(this.innerHTML)'>".$row['first']."</label><br>";		
	}
	if(str_contains($row['second'], $typed)){
      echo "<label id='thetags' onclick='checker(this.innerHTML)'>".$row['second']."</label><br>";		
	}
	if(str_contains($row['third'], $typed)){
      echo "<label id='thetags' onclick='checker(this.innerHTML)'>".$row['third']."</label><br>";		
	}
	if(str_contains($row['fourth'], $typed)){
      echo "<label id='thetags' onclick='checker(this.innerHTML)'>".$row['fourth']."</label><br>";		
	}
	if(str_contains($row['fifth'], $typed)){
      echo "<label id='thetags' onclick='checker(this.innerHTML)'>".$row['fifth']."</label><br>";		
	}



}

echo "</div>";
}


}


?>