@extends('layouts.app')

@section('content')
	<section class="h-screen" id="main-image">
        <div class="flex items-center justify-center text-center h-full">
            <div>
                <h1 class="text-4xl text-green-500 sm:text-5xl font-semibold leading-none mb-4">Matsu Sushi</h1>
                <h2 class="text-2xl sm:text-3xl text-gray-500 font-normal leading-tight mb-8">Japanese & Korean Fusion Restaurant</h2>
            </div>
        </div>
    </section>
	<section class="bg-white sm:py-8">
		<div class="max-w-3xl mx-auto w-5/6 my-8">
            <div class="flex text-gray-700 text-lg py-8 my-8 leading-relaxed">
                For the past ten years, chefs at Matsu Sushi have worked passionately together to provide guests with a unique Japanese & Korean dining experience in Peterborough, Ontario. More than just a sushi restaurant, Matsu Sushi features fresh and interesting ingredients that are firmly rooted in Japanese & Korean culinary tradition. The result is an experience that is refreshing and new.
            </div>
        </div>
    </section>
    <section class="bg-blue-100 py-8">
        <div class="max-w-3xl mx-auto w-5/6 my-8">
            <div class="flex flex-col justfiy-center text-center pb-8">
                <h2 class="font-semibold leading-none opacity-75 sm:text-4xl text-3xl text-gre tracking-normal">Delivery is available!</h2>
            </div>
            <div class="bg-white rounded shadow-lg overflow-hidden">
                <div class="flex flex-col-reverse md:flex-row">
                    <div class="flex-1 flex items-center bg-gray-50 p-8">
                        <ul class="my-6">
                            <li class="mb-8">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="align-middle text-teal-500" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <p class="text-md leading-normal">PHONE: (705) 760-9484</p>
                                </div>
                            </li>
                            <li class="mb-8">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="align-middle text-teal-500" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <p class="text-md leading-normal">
                                        OPEN: Mon-Sun 11:30 AM ~ 10:00 PM
                                        <br>
                                        (Tuesdays closed)
                                    </p>
                                </div>
                            </li>
                            <li class="">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="align-middle text-teal-500" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    </div>
                                    <p class="text-md leading-normal">HOLIDAY CLOSURES: Christmas(12/25), New Year's Day(1/1)</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 p-8">
						<div class="flex flex-col h-full items-center justfiy-center">
							<h3 class="font-bold leading-none mb-6 text-xl text-pink-500">Most Ordered Item:</h3>
							<p class="font-normal leading-none mb-6 opacity-75 text-blue-700 text-xl">Peterborough Combo</p>
							<div class="flex flex-1 mb-6">
								<div class="flex self-start items-center">
									<span class="leading-none mr-2 text-2xl text-gray-600">$</span>
                                    <span class="font-semibold leading-none mr-3 text-3xl text-teal-500 tracking-tighter">18.95</span>
                                </div>
                            </div>
							<p class="font-normal leading-none mb-6 opacity-75 text-blue-700 text-xl">Kawartha Combo</p>
							<div class="flex flex-1 mb-6">
								<div class="flex self-start items-center">
									<span class="leading-none mr-2 text-2xl text-gray-600">$</span>
                                    <span class="font-semibold leading-none mr-3 text-3xl text-teal-500 tracking-tighter">24.95</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection('content')

