<?php

include("libs/functions.php");

// true =  success, false 
$status = doLogin($_POST["strEmail"], $_POST["strPassword"]);

if($status)
{
	header("location: animallist.php");
} else {
	header("location: index.php?error=1");
}
?>