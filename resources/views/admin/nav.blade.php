	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<a class="navbar-brand" href="/admin/chat">Admin</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExample04">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ $admin_chat or '' }}">
					<a class="nav-link" href="/admin/chat">Chat</a>
				</li>
				<li class="nav-item {{ $admin_upload or '' }}">
					<a class="nav-link" href="/admin/uploadImage">Upload <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled" href="#">Link</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="/logout" title="Log Out"><span id="adminName">{{ $adminName }}</span><span class="invisible" id="adminID">{{ $adminID }}</span></a>
				</li>
			</ul>
		</div>
	</nav>
