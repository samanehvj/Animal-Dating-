<?php
include("libs/functions.php");
include("includes/header.php");

// $currentUser = getCurrentUser();
?>

<body>
	<div class="wrapper">

		<div class="content top-align-contents lists" id="matchList">
			<div class="title">
				<h1>Match List</h1>
				<p> Chat</p>
			</div>

			<?php
			$arrMatches = getMatches();


			foreach ($arrMatches as $userMatched) {
			?>
				<div class="match">
					<a href="chat.php?nUsersID=<?= $userMatched["nMatchedUserID"] ?>">
						<div class="matchIcon" imgsrc="<?= $userMatched["strPhoto"] ?>"></div>

						<h2><?= $userMatched["strNickName"] ?></h2>
					</a>
				</div>
			<?php
			}
			?>

		</div><!-- end of content -->

		<?php
		$matchesActive = "active";
		include("includes/nav.php");
		?>

	</div><!-- end of wrapper -->



	<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/main.js"></script>

</body>

</html>