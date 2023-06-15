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
			// send like to the server
			vote(1);

			// part two: get new random animal
			getNewRandomAnimal();
		})

		$("#matchmessage").on("click", function() {
			$("#matchmessage").hide();
		})


		$("#noBtn").on("click", function() {
			// send like to the server
			vote(0);

			// part two: get new random animal
			getNewRandomAnimal();
		})
	})

	function getNewRandomAnimal() {
		$.ajax({
			url: "getAnimal.php",
			success: function(response) {
				$("#thecard").html(response);

				processImageBackground();
			},
			error: function() {
				console.log(" something went wrong...");
			}
		})
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
				console.log(" something went  wrong...");
			}
		})
	} -->