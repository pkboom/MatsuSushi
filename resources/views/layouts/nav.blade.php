<header id="header" class="absolute bg-transparent sm:bg-white top-0 left-0 w-full py-4 z-10">
		<div class="w-full flex flex-col sm:flex-row sm:justify-between items-center px-12">
			<a href="/" class="flex-shrink-0 text-2xl text-gray-800 font-semibold">Matsu Sushi</a>
			<div id="menu" class="w-full hidden flex-col items-center sm:flex sm:flex-row sm:justify-end mt-2">
				<a href="/" class="w-full sm:w-auto text-center leading-normal text-indigo-700 hover:text-indigo-900 opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('/') ? 'active' : '' }}">HOME</a>
				<a href="/menu" class="w-full sm:w-auto text-center leading-normal text-indigo-700 hover:text-indigo-900 opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('menu') ? 'active' : '' }}">MENU</a>
				<a href="/order" class="w-full sm:w-auto text-center leading-normal text-indigo-700 hover:text-indigo-900 opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('order') ? 'active' : '' }}">ORDER</a>
				<a href="/gallery" class="w-full sm:w-auto text-center leading-normal text-indigo-700 hover:text-indigo-900 opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('gallery') ? 'active' : '' }}">GALLERY</a>
				<a href="/contact" class="w-full sm:w-auto text-center leading-normal text-indigo-700 hover:text-indigo-900 opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('contact') ? 'active' : '' }}">CONTACT</a>
			</div>
		</div>
		<div class="sm:hidden absolute top-0 right-0 pr-4 pt-4">
			<a href="#" class="block text-gray-800 p-2 rounded" onclick="
				document.getElementById('header').classList.toggle('bg-gray-100');
				document.getElementById('menu').classList.toggle('flex');
			">&#9776;</a>
		</div>
</header>
