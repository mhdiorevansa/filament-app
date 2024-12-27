<div>
		<div id="camera"></div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
		<script>
				document.addEventListener("DOMContentLoaded", function(event) {
						Webcam.set({
								width: 390,
								height: 350,
								image_format: 'jpeg',
								jpeg_quality: 90
						});

						Webcam.attach('#camera');
				});
		</script>
</div>
