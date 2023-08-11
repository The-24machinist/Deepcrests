<?php

if(isset($_POST['filteritman'])){
$thepersonality=$_POST['filterit'];

$result = mysqli_query($con,"SELECT * FROM personality WHERE first='$thepersonality' OR second='$thepersonality' OR third='$thepersonality' OR fourth='$thepersonality' OR fifth='$thepersonality'");

while ($row = mysqli_fetch_assoc($result)) {
    $theperson=$row['username'];
    echo "<a href='".$theperson."' target='_parent'>".$theperson."</a>";
    echo "<br>";
}


}


?>