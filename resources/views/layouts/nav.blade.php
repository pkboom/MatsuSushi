<header id="header" class="absolute bg-transparent sm:bg-white pin-t pin-l w-full py-4 z-10">
		<div class="w-full flex flex-col sm:flex-row sm:justify-between items-center px-12">
			<a href="/" class="flex-no-shrink text-2xl text-grey-darkest font-semibold mb-2">Matsu Sushi</a>
			<div id="menu" class="w-full hidden flex-col items-center sm:flex sm:flex-row sm:justify-end mt-2">
				<a href="/" class="w-full sm:w-auto text-center text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('/') ? 'active' : '' }}">HOME</a>
				<a href="/menu" class="w-full sm:w-auto text-center text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('menu') ? 'active' : '' }}">MENU</a>
				<a href="/gallery" class="w-full sm:w-auto text-center text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('gallery') ? 'active' : '' }}">GALLERY</a>
				<a href="/contact" class="w-full sm:w-auto text-center text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 py-2 {{ request()->is('contact') ? 'active' : '' }}">CONTACT</a>
			</div>
		</div>
		<div class="sm:hidden absolute pin-t pin-r pr-4 pt-4">
			<a href="#" class="block text-grey-darkest p-2 rounded" onclick="
				document.getElementById('header').classList.toggle('bg-grey-lightest');
				document.getElementById('menu').classList.toggle('flex');
			">&#9776;</a>
		</div>
</header>
