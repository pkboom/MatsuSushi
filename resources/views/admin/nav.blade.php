	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="/admin/chat">Admin</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExample04">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ request()->is('admin/chat') ? 'active' : '' }}">
					<a class="nav-link" href="/admin/chat">Chat</a>
				</li>
				<li class="nav-item {{ request()->is('admin/upload-image') ? 'active' : '' }}">
					<a class="nav-link" href="/admin/upload-image">Image</a>
				</li>
				<li class="nav-item {{ request()->is('menu/categories') ? 'active' : '' }}">
					<a class="nav-link" href="/menu/categories">Menu</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="/logout" title="Log Out"><span id="adminName">{{ auth()->user()->name }}</span><span class="invisible" id="adminID">{{ auth()->user()->id }}</span></a>
				</li>
			</ul>
		</div>
	</nav>
