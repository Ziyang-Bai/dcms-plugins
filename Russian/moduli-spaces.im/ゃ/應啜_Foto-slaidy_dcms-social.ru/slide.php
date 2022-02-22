<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<title>Slides, A Slideshow Plugin for jQuery</title>
	
	<link rel="stylesheet" href="css/style.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script src="js/slides.js"></script>

	<script>
		/*
			Get the curent slide
		*/
		function currentSlide( current ) {
			$(".current_slide").text(current + " of " + $("#slides").slides("status","total") );
		}
		
		$(function(){
			/*
				Initialize SlidesJS
			*/
			$("#slides").slides({
				navigateEnd: function( current ) {
					currentSlide( current );
				},
				loaded: function(){
					currentSlide( 1 );
				}
			});
			
			/*
				Play/stop button
			*/
			$(".controls").click(function(e) {
				e.preventDefault();
				
				// Example status method usage
				var slidesStatus = $("#slides").slides("status","state");
				
				if (!slidesStatus || slidesStatus === "stopped") {

					// Example play method usage
					$("#slides").slides("play");

					// Change text
					$(this).text("Stop");
				} else {
					
					// Example stop method usage
					$("#slides").slides("stop");
					
					// Change text
					$(this).text("Play");
				}
			});
		});
	</script>
</head>
<body>
	
	<div id="container">
		
		<!-- start SlidesJS slideshow -->
		<div id="slides">
				<img src="BY HEADSTYLE" width="400" height="250" alt="Slide 1">
				
				<img src="BY HEADSTYLE" width="400" height="250" alt="Slide 2">

				<img src="BY HEADSTYLE" width="400" height="250" alt="Slide 3">

				<img src="BY HEADSTYLE" width="400" height="300" alt="Slide 4">

				<img src="BY HEADSTYLE" width="400" height="300" alt="Slide 5">

				<img src="BY HEADSTYLE" width="400" height="300" alt="Slide 6">

				<img src="BY HEADSTYLE" width="400" height="300" alt="Slide 7">
		</div>
		<!-- end SlidesJS  slideshow -->
		
		<!-- Example play/stop controls -->
		<a href="#" class="controls">Play</a>
		
		<!-- Example slide count -->
		<p class="current_slide"></p>
	</div>
	
</body>
</html>