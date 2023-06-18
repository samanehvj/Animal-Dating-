
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
