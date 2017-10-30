@extends('layouts.master')

@section('content')
<?php $nav_home = "active"; ?>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class="first-slide" src="/image/carousel_1.jpg" alt="First slide">
		</div>
		<div class="carousel-item">
			<img class="second-slide" src="/image/carousel_2.jpg" alt="Second slide">
		</div>
		<div class="carousel-item">
			<img class="third-slide" src="/image/carousel_3.jpg" alt="Third slide">
		</div>
	</div>
	<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>


<!-- Marketing messaging and featurettes -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container reading-box">
	<div class="row justify-content-center">
		<div class="col">
			<p>
				For the past ten years, chefs at Matsu Sushi have worked passionately together to provide guests with a unique Japanese & Korean dining experience in Peterborough, Ontario. More than just a sushi restaurant, Matsu Sushi features fresh and interesting ingredients that are firmly rooted in Japanese & Korean culinary tradition. The result is a experience that is refreshing and new.

			</p>
		</div>        
	</div>
</div>

<div class="container marketing">

	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="col-lg-4">
			<a href="#">
				<img class="rounded-circle" src="/image/main_1.jpg" alt="Generic placeholder image" width="250" height="250">
			</a>
		</div><!-- /.col-lg-4 -->
		<div class="col-lg-4">
			<a href="#">
				<img class="rounded-circle" src="/image/main_2.jpg" alt="Generic placeholder image" width="250" height="250">
			</a>
		</div><!-- /.col-lg-4 -->
		<div class="col-lg-4">
			<a href="#">
				<img class="rounded-circle" src="/image/main_3.jpg" alt="Generic placeholder image" width="250" height="250">
			</a>
		</div><!-- /.col-lg-4 -->
	</div><!-- /.row -->


	<!-- START THE FEATURETTES -->

	<hr class="featurette-divider">

	<div class="row featurette">
		<div class="col-md-7">
			<h2 class="featurette-heading">Delivery is available! </h2>
			<p class="lead">
				<span style="font-weight: 400">PHONE:</span> (705) 760-9484<br >
				<span style="font-weight: 400">OPEN:</span> Mon-Sun 11:30 AM ~ 10:00 PM<br >
				<span style="font-weight: 400">CLOSED:</span> Monday of 2nd Week Every Month<br >
				<span style="font-weight: 400">HOLIDAY CLOSURES:</span> Christmas(12/25), New Year's Day(1/1)
			</p>
		</div>
		<div class="col-md-5">
			<img class="img-fluid mx-auto" src="/image/main-bottom.png" alt="Generic placeholder image">
		</div>
	</div>
</div><!-- /.container -->
@endsection('content')

