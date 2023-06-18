<?php

include("libs/functions.php");

// true =  success, false = user already exists
$status = doRegister($_POST["strEmail"], $_POST["strPassword"], $_POST["strLocation"]);

if($status)
{
	header("location: me.php");
} else {
	header("location: register.php?error=1");
}
