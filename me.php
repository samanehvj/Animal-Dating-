<?php
include("libs/functions.php");
include("includes/header.php");

$currentUser = getCurrentUser();

?>
<div class="wrapper">

	<div class="content cv-align-contents">
		<div class="card" id="login">
			<div class="editProfilePhoto">
				<div id="thePhoto" imgsrc="assets/<?= $currentUser['strPrimaryPhoto'] ?>"></div>
			</div>
			<h1>Edit Profile</h1>
			<p>Complete the form below to update the details</p>
			<form method="post" action="updateProfile.php" enctype="multipart/form-data">
				<div class="fieldgroup">
					<label> Name</label>
					<input type="text" name="strNickName" placeholder="What name should users see" value="<?= $currentUser['strNickName'] ?>" />
				</div>

				<div class="fieldgroup">
					<label>Where Are You Located</label>
					<!-- <input type="text" name="strLocation" placeholder="Zoo Region" value="<?= $currentUser['strLocation'] ?>" /> -->
					<input class="magicInput" data-tbl="countries" name="strLocation" placeholder="Zoo Region..." value="<?= $currentUser['strLocation'] ?>" />
					<div class=" magicList"></div>
				</div>

				<div class="fieldgroup">
					<label>Tell Us About You!</label>
					<textarea name="strBio"><?= $currentUser['strBio'] ?></textarea>
				</div>

				<div class="fieldgroup">
					<label>Where Should Your Matches Live?</label>
					<div class="checklist">
						<?php
						$locationOptions = getLocations();
						$myDesiredLocations = getDesiredLocations();



						foreach ($locationOptions as $location) {

							$checked = (isset($myDesiredLocations[$location["strLocation"]])) ? "checked" : "";

						?>
							<div>
								<input type="checkbox" name="desiredLocations[]" value="<?= $location["strLocation"] ?>" <?= $checked ?>>
								<span><?= $location["strLocation"] ?></span>
							</div>
						<?php
						}
						?>
					</div>
				</div>



				<input type="file" name="strProfilePhoto" id="profilePhotoField">

				<div class="fieldgroup">
					<input type="submit" value="Save Profile" class="btn-primary" />

				</div>
			</form>
		</div>
	</div>

</div>
<?php
$profileActive = "active";
include("includes/nav.php");
?>

<!-- <script>
	var photoTrigger = document.getElementById("thePhoto");
	var photoUploadField = document.getElementById("profilePhotoField");

	photoTrigger.addEventListener("click", function() {
		photoUploadField.click();
	})

	photoUploadField.addEventListener("change", function(event) {
		var file = event.target.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			photoTrigger.style.backgroundImage = 'url(' + e.target.result + ')';
		}

		reader.readAsDataURL(file);

	});

	var ImagePath = photoTrigger.getAttribute("imgsrc");
	photoTrigger.style.backgroundImage = 'url(' + ImagePath + ')';
</script> -->

<script type="text/javascript" src="js/profileImage.js"></script>


</body>

</html>