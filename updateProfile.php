<?php

include("libs/functions.php");


updateProfile($_POST["strNickName"], $_POST["strLocation"], $_POST["strBio"], "strProfilePhoto", $_POST["desiredLocations"]);


header("location: animallist.php");
