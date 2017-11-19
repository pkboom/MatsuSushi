<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Register</title>

	<!-- Bootstrap core CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-8">
				<h1 class="register-head">Register</h1>
				<form method="POST" action="/register">
					{!! csrf_field() !!}

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" required>
					</div>

					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>

					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>

					<div class="form-group">
						<label for="password_confirmation">Password Confimation:</label>
						<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
					</div>

					<button type="submit" class="btn btn-primary">Register</button>

					@include ('layouts.errors')
				</form>
			</div>
		</div>

	</div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script type="text/javascript" src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>

</body>
</html>
