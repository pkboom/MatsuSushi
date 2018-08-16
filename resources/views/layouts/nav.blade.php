<header id="header" class="absolute bg-transparent sm:bg-white pin-t pin-l w-full py-4 z-10">
		<div class="w-full flex flex-col items-center sm:flex-row sm:justify-between px-12">
			<a href="/" class="text-2xl tracking-tight text-grey-darkest font-semibold mb-2">Matsu Sushi</a>
			<div id="menu" class="hidden flex-col items-center sm:flex sm:flex-row mt-2">
				<a href="/" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 mb-2 {{ request()->is('/') ? 'active' : '' }}">HOME</a>
				<a href="/menu" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 mb-2 {{ request()->is('menu') ? 'active' : '' }}">MENU</a>
				<a href="/gallery" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 mb-2 {{ request()->is('gallery') ? 'active' : '' }}">GALLERY</a>
				<a href="/contact" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 mb-2 {{ request()->is('contact') ? 'active' : '' }}">CONTACT</a>
			</div>
		</div>
		<div class="sm:hidden absolute pin-t pin-r pr-5 pt-6">
			<a href="#" class="text-grey-darkest" onclick="
				document.getElementById('header').classList.toggle('bg-grey-lightest');
				document.getElementById('menu').classList.toggle('flex');
			">&#9776;</a>
		</div>
</header>
