  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="/">Matsu Sushi</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
					<a class="nav-link" href="/">HOME</a>
				</li>
				<li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
					<a class="nav-link" href="/about">ABOUT</a>
				</li>
				<li class="nav-item {{ request()->is('menu') ? 'active' : '' }}">
					<a class="nav-link" href="/menu">MENU</a>
				</li>
				<li class="nav-item {{ request()->is('gallery') ? 'active' : '' }}">
					<a class="nav-link" href="/gallery">GALLERY</a>
				</li>
				<li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
					<a class="nav-link" href="/contact">CONTACT</a>
				</li>
			</ul>
			<div class="order">
				<a class="btn btn-outline-secondary my-2 my-sm-0" href="/cart">
					<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20 20">
						<path fill="currentColor" d="M14.6,1H5.398C4.629,1,4,1.629,4,2.4v15.2C4,18.37,4.629,19,5.398,19H14.6c0.769,0,1.4-0.631,1.4-1.4V2.4
							C16,1.629,15.369,1,14.6,1z M7,12c0.689,0,1.25,0.447,1.25,1S7.689,14,7,14c-0.69,0-1.25-0.447-1.25-1S6.31,12,7,12z M5.75,10
							c0-0.553,0.56-1,1.25-1c0.689,0,1.25,0.447,1.25,1c0,0.553-0.561,1-1.25,1C6.31,11,5.75,10.553,5.75,10z M7,15
							c0.689,0,1.25,0.447,1.25,1c0,0.553-0.561,1-1.25,1c-0.69,0-1.25-0.447-1.25-1S6.31,15,7,15z M10,12c0.689,0,1.25,0.447,1.25,1
							s-0.561,1-1.25,1c-0.69,0-1.25-0.447-1.25-1S9.31,12,10,12z M8.75,10c0-0.553,0.56-1,1.25-1c0.689,0,1.25,0.447,1.25,1
							c0,0.553-0.561,1-1.25,1C9.31,11,8.75,10.553,8.75,10z M10,15c0.689,0,1.25,0.447,1.25,1c0,0.553-0.561,1-1.25,1
							c-0.69,0-1.25-0.447-1.25-1S9.31,15,10,15z M13,12c0.689,0,1.25,0.447,1.25,1s-0.561,1-1.25,1c-0.69,0-1.25-0.447-1.25-1
							S12.31,12,13,12z M11.75,10c0-0.553,0.56-1,1.25-1c0.689,0,1.25,0.447,1.25,1c0,0.553-0.561,1-1.25,1
							C12.31,11,11.75,10.553,11.75,10z M13,15c0.689,0,1.25,0.447,1.25,1c0,0.553-0.561,1-1.25,1c-0.69,0-1.25-0.447-1.25-1
							S12.31,15,13,15z M5,7V4h10v3H5z"/>
					</svg>
					&nbsp;ORDER
					<span class="badge" id="cart-badge">
				</a>
			</div>
		</div>
	</nav>
		