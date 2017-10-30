@extends('layouts.master')

@section('content')
	<?php $nav_about = "active"; ?>

	<div class="container">
		<div class="row about">
			<div class="col-lg-6 about-image-container">
				<img class="mx-auto about-image" src="/image/about.jpg" alt="Generic placeholder image">

			</div>        
			<div class="col-lg-6 align-self-center about-paragraph-container">
				<div class="about-paragraph-top">
					<h4>
						Sushi Takes Many Forms 					
					</h4>
					<p>
						Using elements of nature and aquatic scenes many types and variations of sushi exist. Vinegar rice is used predominantly, with the fish being sashimi. The two combined create sushi and rolled together create MAKI SUSHI. Enjoy this centuries old tradition.			
					</p>				
				</div>
				<hr class="about-paragraph-gap">
				<div>
					<h4>
						For Thousands of Years 
					</h4>
					<p>					
						Sushi has been an integral part of the Japanese diet and culture, and has developed in to a culinary art form. A great deal of discipline, high standards and honor is learned throughout this samural-like process stepped in tradition.
						Try our sushi at Matsu Sushi
					</p>
				</div>
			</div>        
		</div>
	</div><!-- /.container -->

@endsection('content')
