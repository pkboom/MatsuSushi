<header id="header" class="absolute pin-t pin-l w-full py-4 z-10">
	<div class="flex justify-between px-8">
		<div class="w-full flex flex-col items-start  sm:flex-row sm:justify-between ">
			<a href="/" class="text-2xl tracking-tight text-grey-darkest font-semibold">Matsu Sushi</a>
			<div id="menu" class="hidden flex-col items-center sm:flex sm:flex-row">
				<a href="/" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 {{ request()->is('/') ? 'active' : '' }}">HOME</a>
				<a href="/menu" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 {{ request()->is('menu') ? 'active' : '' }}">MENU</a>
				<a href="/gallery" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 {{ request()->is('gallery') ? 'active' : '' }}">GALLERY</a>
				<a href="/contact" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline sm:ml-8 {{ request()->is('contact') ? 'active' : '' }}">CONTACT</a>
			</div>
		</div>
		<div class="sm:hidden">
			<a href="#" class="text-grey-darkest" onclick="
				document.getElementById('header').classList.toggle('bg-white');
				document.getElementById('menu').classList.toggle('flex');
			">&#9776;</a>
		</div>
	</div>
</header>
