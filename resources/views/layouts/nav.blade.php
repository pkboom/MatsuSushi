  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  	<a class="navbar-brand" href="/">Matsu Sushi</a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
  		<span class="navbar-toggler-icon"></span>
  	</button>
  	<div class="collapse navbar-collapse" id="navbarCollapse">
  		<ul class="navbar-nav mr-auto">
  			<li class="nav-item {{ $nav_home or '' }}">
  				<a class="nav-link" href="/">HOME</a>
  			</li>
  			<li class="nav-item {{ $nav_about or '' }}">
  				<a class="nav-link" href="/about">ABOUT</a>
  			</li>
  			<li class="nav-item {{ $nav_menu or '' }}">
  				<a class="nav-link" href="/menu">MENU</a>
  			</li>
  			<li class="nav-item {{ $nav_gallery or '' }}">
  				<a class="nav-link" href="/gallery">GALLERY</a>
  			</li>
        <li class="nav-item {{ $nav_contact or '' }}">
          <a class="nav-link" href="/contact">CONTACT</a>
        </li>
  		</ul>
  		<form class="form-inline mt-2 mt-md-0">
  			<a class="btn btn-outline-secondary my-2 my-sm-0" href="/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;CART<span class="badge" id="cart-badge"></a>
  		</form>
  	</div>
  </nav>
