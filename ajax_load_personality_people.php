<?php

include("config/config.php");
include("includes/classes/User.php");



if(isset($_POST['personality'])){
$typed=$_POST['personality'];
//$userLoggedIn = $_SESSION['username'];
$college=$_POST['college'];
$returnthis="";
$max=$_POST['max'];

$usersReturne = mysqli_query($con, "SELECT DISTINCT * FROM personality WHERE (first LIKE '%$typed%' OR second LIKE '%$typed%' OR third LIKE '%$typed%' OR fourth LIKE '%$typed%' OR fifth LIKE '%$typed%') AND college='$college'");
	$count = mysqli_num_rows($usersReturne);

	if($count != 0) {
$counts = 0; //Number of messages posted
		while($people = mysqli_fetch_array($usersReturne)) {


$counts=$counts+1;

$returnthis.="<a id='namesofpeople' target='_parent' href=".$people['username']."><div id='divnamesofpeople'> ".$people['username']."</div></a><br>";

if($counts>=$count){
	break;
}

if($counts>=$max){

	break;
}



}




if($counts>=$count)
	          {
	$returnthis.="No more people to load bitch fucking ass fucking ass fucks";
			
	       	}
	       	else{
	       		$returnthis.="<label id='loadmorepersonality' onclick='checkpers(this.innerHTML)'>".$typed."</label>";
	       	}


echo $returnthis;
}
else{
	echo "There are no people at all from your college";
}
}

?>