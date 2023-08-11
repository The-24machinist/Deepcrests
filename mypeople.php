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

	</script>





<!---<form action="mypeople.php" method="POST">------>
<input type="text" onkeyup="Searchforpersonality(this.value)" name="filterit">
<!---<input type="submit" value="filter" name="filteritman">---->
<!------</form>------->

<div id="autopers"></div>
<br>
<div id="thepersonnames">
		<br>
	</div>

<!--- This is to load the people even without clicking the load more button nigger(think about this shit nigger)
<script type="text/javascript">
	hello();
</script>
-->

<script type="text/javascript">
	function Searchforpersonality(typed){

var getterdiv=document.getElementById("autopers");
var collegename='<?php  echo $collegename; ?>';
        $.ajax({

     url : 'ajax_get_personality.php',
     type : 'POST',
     data: {college: collegename, stuff: typed},
     success : function (result) {
       // console.log (result); // Here, you need to use response by PHP file.
        
        getterdiv.innerHTML=result.toString();

     },
     error : function (request, status, error) {
        console.log (request.responseText);
         
     }

   });

	}

//this is for the loading the people whenn we click on the personality tags 

function checker(personalitything){

var thepersonanme=document.getElementById("thepersonnames");

thestuff2=1;
	$.ajax({

     url : 'ajax_load_personality_people.php',
     type : 'POST',
     data: {college: collegename, max: thestuff2, personality: personalitything},
     success : function (result) {
       // console.log (result); // Here, you need to use response by PHP file.
        
        thepersonanme.innerHTML=result.toString();

     },
     error : function (request, status, error) {
        console.log (request.responseText);
         
     }

   });
}

// this is for loading more people when it is exhausted based on the personality tags


function checkpers(personalitythin){

var thepersonanme=document.getElementById("thepersonnames");
var thelimitinge=1;



thestuff2+=thelimitinge;
	$.ajax({

     url : 'ajax_load_personality_people.php',
     type : 'POST',
     data: {college: collegename, max: thestuff2, personality: personalitythin},
     success : function (result) {
       // console.log (result); // Here, you need to use response by PHP file.
        
        thepersonanme.innerHTML=result.toString();

     },
     error : function (request, status, error) {
        console.log (request.responseText);
         
     }

   });
}



</script>





</body>
</html>