@extends('layouts.master')

@section('content')
	<section class="bg-white pt-8 mt-8 -mb-1" >
		<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/view?zoom=17&center=44.3065%2C-78.3088&key=AIzaSyAA3ikuYTSKZPPXVWgAOgIlSoGJKpviLgw" allowfullscreen></iframe>
	</section>

    <section class="bg-grey-lightest py-8">
        <div class="w-5/6 max-w-2xl mx-auto my-8">
            <div class="flex flex-wrap -mx-6 -my-6">
                <div class="w-full lg:w-1/2 px-6 py-6">
					<div class="bg-pink-dark rounded shadow-lg overflow-hidden p-8 min-h-full">
						<h5 class="text-xl text-white mb-4">CONTACT</h5>
						<p class="text-lg text-white leading-tight">
							107 Hunter St. East Suite 102 Peterborough<br>
							Ontario, Canada<br>
							(705) 760-9484
						</p>
					</div>
                </div>
                <div class="w-full lg:w-1/2 px-6 py-6">
					<div class="bg-red-light rounded shadow-lg overflow-hidden p-8 min-h-full">
						<h5 class="text-xl text-white mb-4">OPERATION</h5>
						<p class="text-lg text-white leading-tight">
							OPEN: Mon-Sun 11:30 AM ~ 10:00 PM<br>
							CLOSED: Every Tuesday<br>
							HOLIDAY CLOSURES: Christmas(12/25), New Year's Day(1/1)
						</p>
					</div>
                </div>
            </div>
        </div>
    </section>

@endsection('content')
