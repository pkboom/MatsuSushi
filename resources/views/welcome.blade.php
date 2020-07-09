@extends('layouts.master')

@section('content')
	<section class="py-8 h-full h-screen" id="main-image">
        <div class="flex items-center justify-center text-center h-full">
            <div>
                <h1 class="text-4xl text-green-600 sm:text-5xl font-semibold leading-none mb-4">Matsu Sushi</h1>
                <h2 class="text-2xl sm:text-3xl text-grey-500 font-normal leading-tight mb-8">Japanese & Korean Fusion Restaurant</h2>
            </div>
        </div>
    </section>

	<section class="bg-white sm:py-8">
		<div class="w-5/6 max-w-xl mx-auto my-8">
            <div class="flex text-xl py-8 my-8 leading-normal">
                For the past ten years, chefs at Matsu Sushi have worked passionately together to provide guests with a unique Japanese & Korean dining experience in Peterborough, Ontario. More than just a sushi restaurant, Matsu Sushi features fresh and interesting ingredients that are firmly rooted in Japanese & Korean culinary tradition. The result is an experience that is refreshing and new.
            </div>
        </div>
    </section>
	
    <section class="bg-grey-300 py-8">
        <div class="w-5/6 max-w-lg mx-auto my-8">
            <div class="flex flex-col justfiy-center text-center pb-8">
                <h2 class="text-3xl sm:text-4xl font-semibold text-grey-600 opacity-75 leading-none tracking-tighter mb-4">Delivery is available!</h2>
            </div>
			
            <div class="bg-white rounded shadow-lg overflow-hidden">
                <div class="flex flex-col-reverse md:flex-row">
                    <div class="flex-1 flex items-center bg-grey-100 p-8">
                        <ul class="my-6">
                            <li class="mb-8">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="align-middle text-teal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <p class="text-lg leading-normal">PHONE: (705) 760-9484</p>
                                </div>
                            </li>
                            <li class="mb-8">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="align-middle text-teal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <p class="text-lg leading-normal">
                                        OPEN: Mon-Sun 11:30 AM ~ 10:00 PM
                                        <br>
                                        (Tuesdays closed)
                                    </p>
                                </div>
                            </li>
                            <li class="">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="align-middle text-teal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <p class="text-lg leading-normal">HOLIDAY CLOSURES: Christmas(12/25), New Year's Day(1/1)</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 p-8">
						<div class="flex flex-col items-start md:items-center h-full">
							<h3 class="text-2xl sm:text-3xl text-blue-700 opacity-75 font-normal leading-none mb-6">Most Ordered Item:</h3>
							<p class="text-2xl text-blue-700 opacity-75 font-normal leading-none mb-6">Peterborough Combo</p>
							<div class="flex flex-1 mb-6">
								<div class="flex self-start items-center">
									<span class="text-3xl text-grey-600 leading-none mr-2">$</span>
                                    <span class="text-4xl font-semibold tracking-tighter leading-none text-teal mr-3">18.95</span>
                                </div>
                            </div>
							<p class="text-2xl text-blue-700 opacity-75 font-normal leading-none mb-6">Kawartha Combo</p>
							<div class="flex flex-1 mb-6">
								<div class="flex self-start items-center">
									<span class="text-3xl text-grey-600 leading-none mr-2">$</span>
                                    <span class="text-4xl font-semibold tracking-tighter leading-none text-teal mr-3">24.95</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection('content')

