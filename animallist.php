<?php
include("libs/functions.php");
include("includes/header.php");

$currentUser = getCurrentUser();

?>


<div class="wrapper">
	<div id="matchmessage">
		<h1>You Matched</h1>
		<img src="https://media.tenor.com/images/06d6db1e93a871969e3eea81bfc9fa50/tenor.gif">
	</div> <!-- end of  matchmessage -->
	<div class="content top-align-contents" id="animalList">
		<div id="thecard">
			<?php
			// get all the animals
			$animals = getAnimals();
			foreach ($animals as $animal) {
			?>
				<div class="profile-card" data-id="<?= $animal["id"] ?>">
					<a href="details.php?profileId=<?= $animal["id"] ?>" class="profile-link">
						<div class="image" imgsrc="<?= $animal["strPrimaryPhoto"] ?>">
						</div>

						<div class="details">
							<h1><?= $animal["strNickName"] ?></h1>
							<span class="region"><?= $animal["strLocation"] ?></span>
						</div> <!-- end of details -->
					</a>
				</div> <!-- end of profile -->
		</div>
	<?php
			}
	?>
	<a href="#" id="likeBtn"><i class="fas fa-heart"></i></a>
	<a href="#" id="noBtn"><i class="fas fa-times-circle"></i>

</a>
	</div> <!-- end of content -->

</div>

<?php
$listActive = "active";
include("includes/nav.php");
?>


<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>


	function processImageBackground() {
		var images = document.querySelectorAll("[imgsrc]");
		for (var i = 0; i < images.length; i++) {
			var whichElement = images[i];
			var imagePath = images[i].getAttribute("imgsrc");
			whichElement.style.backgroundImage = "url(assets/" + imagePath + ")";
		}
	}
	//  first load of the page
	processImageBackground();


	$(function() {
		$("#likeBtn").on("click", function() {
			// 1- send like to the server
			vote(1);

			// 2- get new random animal
			getNewRandomAnimal();
		})

		$("#matchmessage").on("click", function()
		{
			$("#matchmessage").hide();
		})


		$("#noBtn").on("click", function() 
		{
			// send like to the server
			vote(0);

			//  get new random animal
			getNewRandomAnimal();
		})
	})

	function getNewRandomAnimal() 
	{
		$.ajax(
		{
			url: "getAnimal.php",
			success: function(response) 
			{
				$("#thecard").html(response);

				processImageBackground();
			},

			error: function() {
				console.log(" something  wrong...");
			}
		})   // end of $.ajax
	}

	function vote(vote) {
		var whichID = $(".profile-card").data("id");
		$.ajax({
			url: "sendVote.php?like=" + vote + "&nUsersID=" + whichID,
			success: function(response) {
				console.log(response);
				if (response == 1) {
					console.log("show message");
					document.getElementById("matchmessage").style.display = "block";
				}

			},

			error: function() {
				console.log(" something wrong...");
			}
		})
	}
</script>

</body>

</html>