<?php
include("libs/functions.php");
include("includes/header.php");

$currentUser = getCurrentUser();

?>


<div class="wrapper">
	
	<div class="content top-align-contents">
		<?
		// go get all the animals
		$animals = getAnimalById($_GET["profileId"]);

		foreach($animals as $animal)

		{
		?>
		<div class="profile-card">
			
				<div class="image" imgsrc="<?=$animal["strPrimaryPhoto"]?>">
				</div>

				<div class="details">
					<h1><?=$animal["strNickName"]?></h1>
					<span class="region"><?=$animal["strLocation"]?></span>
					<h2>Introduction</h2>
					<p><?=$animal["strBio"]?></p>
				</div> <!-- end of  details -->

				<div class="actions">
					<a href="#" class="btn-primary">Message</a>
					<a href="#" class="btn-neg">Block</a>
				</div> <!-- end of  actions -->
			
		</div>	 <!-- end of  card -->

		<?php

			}
		
		?>
	</div>  <!-- end of  content -->

</div>  <!-- end of  wrapper -->


<?php
$listActive = "active";
include("includes/nav.php");
?>

<script type="text/javascript" src="js/details.js"></script>

<!-- <script>

var images = document.querySelectorAll("[imgsrc]");
for(var i=0; i<images.length; i++)
{
	var whichElement = images[i];
	var imagePath = images[i].getAttribute("imgsrc");
	whichElement.style.backgroundImage = "url(assets/"+imagePath+")";
}


</script> -->

</body>
</html>