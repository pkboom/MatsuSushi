@extends('layouts.app')

@section('content')
	<section class="bg-white pt-8 mt-8 -mb-1" >
		<div id="map" style="width: 100%; height: 500px;"></div>
	</section>

    <section class="py-8">
        <div class="w-5/6 max-w-4xl mx-auto my-8">
            <div class="flex flex-wrap -mx-6 -my-6">
                <div class="w-full lg:w-1/2 px-6 py-6">
					<div class="bg-pink-500 rounded shadow-lg overflow-hidden p-8 min-h-full">
						<h5 class="text-lg text-white mb-4">CONTACT</h5>
						<p class="text-md text-white">
							107 Hunter St. East Suite 102 Peterborough<br>
							Ontario, Canada<br>
							(705) 760-9484
						</p>
					</div>
                </div>
                <div class="w-full lg:w-1/2 px-6 py-6">
					<div class="bg-red-500 rounded shadow-lg overflow-hidden p-8 min-h-full">
						<h5 class="text-lg text-white mb-4">OPERATION</h5>
						<p class="text-md text-white">
							OPEN: Mon-Sun 11:30 AM ~ 10:00 PM<br>
							(Tuesdays closed)<br>
							HOLIDAY CLOSURES: Christmas(12/25), New Year's Day(1/1)
						</p>
					</div>
                </div>
            </div>
        </div>
    </section>
@endsection('content')

@section('javascript')
	<script>
		function initMap() {
			new google.maps.Map(
				document.getElementById('map'), {zoom: 17, center: {lat: 44.3065, lng: -78.3088}}
			);
		}
    </script>
   
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"></script>
@endsection