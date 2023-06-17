<?php
session_start();

function con()
{
	return mysqli_connect("localhost", "root", "root", "zoo_matching");
}

function doLogin($email, $password)
{
	$sql = "SELECT * FROM users WHERE strEmail='" . $email . "' AND strPassword='" . $password . "'";
	$results = mysqli_query(con(), $sql);

	// get the first and only record 
	$userFound = mysqli_fetch_assoc($results);
	if ($userFound) {
		$_SESSION["userID"] = $userFound["id"]; // save the users id to the sessions
	}

	return $userFound; // returns something if found, false it not
}

function doRegister($email, $password, $location)
{
	// first... check if user exists... 
	// if the function getUserByEmail gives me NOTHING back.... then there was no user found by this email.

	if (!getUserByEmail($email)) {
		$sql = "INSERT INTO users (strEmail, strPassword, strLocation) VALUES ('" . $email . "', '" . $password . "', '" . $location . "')";
		$con = con();

		mysqli_query($con, $sql);

		// we have registered... 

		// get the new ID
		$lastID = mysqli_insert_id($con);

		$_SESSION["userID"] = $lastID;

		return true; // this is terrible. 
	} else {
		// there was a user found.... 
		$_SESSION["userID"] = false;
		return false;
	}
}

function getUserByEmail($email)
{
	$sql = "SELECT * FROM users WHERE strEmail='" . $email . "'";
	$results = mysqli_query(con(), $sql);

	// get the first and only record... if it exists.. 
	$userFound = mysqli_fetch_assoc($results);

	return $userFound;
}

function updateProfile($strNickName, $strLocation, $strBio, $fileFieldName, $desiredLocations)
{
	$profilePhotoName = $_FILES[$fileFieldName]["name"];
	if (!$profilePhotoName) {
		$currentUser = getCurrentUser();
		$profilePhotoName = $currentUser["strPrimaryPhoto"];
	} else {
		// upload the file!!!
		move_uploaded_file($_FILES[$fileFieldName]["tmp_name"], "assets/" . $_FILES[$fileFieldName]["name"]);
	}

	$sql = "UPDATE users SET strNickName='" . $strNickName . "', strLocation='" . $strLocation . "', strBio='" . $strBio . "' WHERE id='" . $_SESSION["userID"] . "'";

	mysqli_query(con(), $sql);

	$sql = "DELETE FROM userphotos WHERE nUsersID='" . $_SESSION["userID"] . "' AND bPrimary='1'";
	mysqli_query(con(), $sql);

	$sql = "INSERT INTO userphotos (nUsersID, strPhoto, bPrimary) VALUES ('" . $_SESSION["userID"] . "', '" . $profilePhotoName . "', '1')";
	mysqli_query(con(), $sql);

	/// step 1: remove all the desired locations for this user... 
	$sql = "DELETE FROM users_desired_locations WHERE nUsersID='" . $_SESSION["userID"] . "'";
	mysqli_query(con(), $sql);

	foreach ($desiredLocations as $locationName) {
		$sql = "INSERT INTO users_desired_locations (nUsersID, strLocation) VALUES ('" . $_SESSION["userID"] . "', '" . $locationName . "')";
		mysqli_query(con(), $sql);
	}
}

function getCurrentUser()
{
	$sql = "SELECT
			    users.*,
			    (SELECT strPhoto FROM userphotos WHERE nUsersID='" . $_SESSION["userID"] . "' AND bPrimary=1) AS strPrimaryPhoto
			FROM
			    users
			LEFT JOIN userphotos ON userphotos.nUsersID=users.id
			WHERE
			    users.id = '" . $_SESSION["userID"] . "'";


	$results = mysqli_query(con(), $sql);

	$userFound = mysqli_fetch_assoc($results);
	if (!$userFound) {
		header("location: index.php");
		die();
	}

	return $userFound;
}

function getAnimals()
{

	$desired = getDesiredLocations();
	$filterSQL = "";
	if ($desired) {

		foreach ($desired as $name => $location) {
			$filterSQL .= " strLocation='" . $name . "' OR";
		}

		$filterSQL = " AND (" . substr($filterSQL, 0, strlen($filterSQL) - 2) . ")";
	}


	$sql = "SELECT

			    users.*,userphotos.strPhoto AS strPrimaryPhoto,
			    RAND() as sorter
			FROM
			    users
			LEFT JOIN userphotos ON userphotos.nUsersID=users.id
			WHERE
			    userphotos.bPrimary = 1
			 AND 
			 	users.id !='" . $_SESSION["userID"] . "'
			 $filterSQL
			 ORDER BY sorter
			 LIMIT 0,1
			 ";


	$results = mysqli_query(con(), $sql);
	return processData($results);
}

function getLocations()
{
	$sql = 'SELECT DISTINCT strLocation FROM users WHERE strLocation!="" ORDER BY strLocation';

	$results = mysqli_query(con(), $sql);
	return processData($results);
}

function getAnimalById($id)
{
	$sql = "SELECT
			    users.*,
			    userphotos.strPhoto AS strPrimaryPhoto
			FROM
			    users
			LEFT JOIN userphotos ON userphotos.nUsersID=users.id
			WHERE
				users.id='" . $id . "'
				AND
			    userphotos.bPrimary = 1";

	$results = mysqli_query(con(), $sql);
	return processData($results);
}

function processData($results)
{
	$array = [];
	while ($data = mysqli_fetch_assoc($results)) {
		$array[] = $data;
	}
	return $array;
}


function getDesiredLocations()
{
	$array = false;

	$sql = "SELECT
			   *
			FROM
			    users_desired_locations
			WHERE
			  	nUsersID='" . $_SESSION["userID"] . "'";

	$results = mysqli_query(con(), $sql);
	while ($data = mysqli_fetch_assoc($results)) {
		$array[$data["strLocation"]] = true;
	}

	return $array;
}


function saveVote($nUsersID)
{

	$sql = "INSERT INTO userlikes (nUsersID, nLikedUserID) VALUES ('" . $_SESSION["userID"] . "', '" . $nUsersID . "')";
	$con = con();

	mysqli_query($con, $sql);
}



function checkMatch($nUsersID)
{
	$sql = "SELECT * FROM userlikes WHERE nUsersID='" . $_SESSION["userID"] . "' AND nLikedUserID='" . $nUsersID . "'";
	$results = mysqli_query(con(), $sql);

	$ILikedSomeone = mysqli_fetch_assoc($results);

	$sql = "SELECT * FROM userlikes WHERE nUsersID='" . $nUsersID . "' AND nLikedUserID='" . $_SESSION["userID"] . "'";
	$results = mysqli_query(con(), $sql);

	$theyLikedMe = mysqli_fetch_assoc($results);

	if ($ILikedSomeone and $theyLikedMe) {
		$sql = "INSERT INTO userMatches (nUsersID, nMatchedUserID) 
			VALUES ('" . $_SESSION["userID"] . "', '" . $nUsersID . "')";
		$results = mysqli_query(con(), $sql);

		$sql = "INSERT INTO userMatches (nMatchedUserID, nUsersID) 
			VALUES ('" . $_SESSION["userID"] . "', '" . $nUsersID . "')";
		$results = mysqli_query(con(), $sql);

		return true;
	} else {
		return false;
	}
}


function getMatches()
{
	$sql = "SELECT um.id, um.nUsersID, um.nMatchedUserID, u.strNickName, up.strPhoto
			FROM userMatches AS um
			LEFT JOIN users u ON u.id = um.nMatchedUserID
			LEFT JOIN userPhotos up ON (up.nUsersID=um.nMatchedUserID AND up.bPrimary=1)
			WHERE um.nUsersID='" . $_SESSION["userID"] . "'";

	// echo $sql;
	$results = mysqli_query(con(), $sql);
	return processData($results);
}


function saveMessage($message, $WhoID)
{
	$sql = "INSERT INTO messages (strMessage, nFromWhoID, nToWhomID) VALUES ('" . $message . "','" . $_SESSION["userID"] . "','" . $WhoID . "')";
	$con = con();
	mysqli_query($con, $sql);
}

function getMessages($withWhoID)
{
	$sql = "SELECT * FROM messages WHERE (nFromWhoID =" . $_SESSION["userID"] . " AND nToWhomID=$withWhoID) OR (nFromWhoID=$withWhoID AND nToWhomID=" . $_SESSION["userID"] . ")";

	$results = mysqli_query(con(), $sql);
	return processData($results);
}
