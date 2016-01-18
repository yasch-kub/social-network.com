$(document).ready(function() {
	$('#avatarDropzone').popover({
		html: true,
		trigger: 'click',
		title: 'Change avatar',
		content: function () {
			var context = '<div id="webcamTranslation" class="text-center">' +
				'<div id="webcamStream">' +
				'<video autoplay>' +
				'</video>' +
				'<button class="btn btn-success" type="button" id="snapshotButton">' +
				'Snapshot' +
				'</button>' +
				'</div>' +
				'<div id="canvas">' +
				'<canvas>' +
				'</canvas>' +
				'<button class="btn btn-danger" type="button" id="snapshotSaveButton">' +
				'Save' +
				'</button>' +
				'</div>' +
				'</div>'
			return context;
		}
	});

	$('#avatarDropzone').click(mediaStream);
});

function mediaStream() {
	var snapshotButton = $('#snapshotButton');
	var snapshotSaveButton = $('#snapshotSaveButton');
	var video = document.querySelector('#webcamTranslation  video');
	var canvasBlock = $('#canvas');
	var canvas = document.querySelector('#webcamTranslation  canvas');
	var vendorURL = window.URL || window.webkitURL;

	navigator.getMedia = navigator.getUserMedia
		|| navigator.webkitGetUserMedia
		|| navigator.mozGetUserMedia
		|| navigator.msGetUserMedia;

	var success = function(stream) {
		console.log(stream);
		video.srcObject = stream;
		video.src = vendorURL.createObjectURL(stream);
		$('#webcamStream').show();
	};

	var error = function(error) {
		console.log(error.name);
		$('#webcamStream').after('Option is not available');
		$('#webcamStream').remove();
	};

	snapshotButton.click(function(event) {
		event.preventDefault();
		canvasBlock.show();
		console.log(video.width, video.height);
		canvas.width = 480;
		canvas.height = 360;
		canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
	});

	snapshotSaveButton.click(function(event) {
		event.preventDefault();
		console.log('Save snapshot');
		var image = canvas.toDataURL();
		$.post('/SaveWebCamImage', image, function(response) {
			console.log(response);
			$('#avatarDropzone img').attr('src', response);
		}, 'json');
	});

	navigator.getMedia({
		video: true,
		audio: false
	}, success, error);
}