<?php
include('forthis.php');
include('filter.php');
?>


<html>
<head>

	<title>My people</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>


	<?php

if (isset($_SESSION['username'])) {
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
		$user = mysqli_fetch_array($user_details_query);
		$collegename=$user['college'];
		
	}
	else {
		header("Location: register.php");
	}



	?>

	<script type="text/javascript">

		var thestuff=0;
		var thestuff2=0;
		var collegename='<?php  echo $collegename; ?>';
		function hello(){

var limity=1;



thestuff+=limity;
var getdiv=document.getElementById("thenames");
	$.ajax({

     url : 'includes/handlers/ajax_load_people.php',
     type : 'POST',
     data: {college: collegename, max: thestuff},
     success : function (result) {
       // console.log (result); // Here, you need to use response by PHP file.
        
        getdiv.innerHTML=result.toString();

     },
     error : function (request, status, error) {
        console.log (request.responseText);
         
     }

   });
}


	</script>




	<div id='thenames'>
		<br>
		<button id
		='loadpeoplebutton' onclick="hello()">Load the people</button>

	</div>
	<br>




</body>
</html>