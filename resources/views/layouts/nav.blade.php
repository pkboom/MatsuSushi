<header class="absolute pin-t pin-l w-full py-4">
	<div class="flex items-center justify-between px-8">
		<span class="text-2xl tracking-tight font-semibold">
			Matsu Sushi
		</span>
		<div>
			<div class="flex items-center">
				<a href="/" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline ml-8 {{ request()->is('/') ? 'active' : '' }}">HOME</a>
				<a href="/about" class="temp text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline ml-8 {{ request()->is('about') ? 'active' : '' }}">ABOUT</a>
				<a href="/menu" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline ml-8 {{ request()->is('menu') ? 'active' : '' }}">MENU</a>
				<a href="/gallery" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline ml-8 {{ request()->is('gallery') ? 'active' : '' }}">GALLERY</a>
				<a href="/contact" class="text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline ml-8 {{ request()->is('contact') ? 'active' : '' }}">CONTACT</a>
				<a href="/cart" class="flex items-center text-lg leading-normal text-indigo hover:text-indigo-darker opacity-75 no-underline ml-8 {{ request()->is('cart') ? 'active' : '' }}">
					ORDER
					<span class="badge" id="cart-badge">
				</a>
			</div>
		</div>
	</div>
</header>
