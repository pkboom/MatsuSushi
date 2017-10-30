<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Register</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<!-- Custom styles for this template -->
	<link href="/css/app.css" rel="stylesheet">
</head>

<body>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-8">
				<h1 class="register-head">Register</h1>
				<form method="POST" action="/register">
					{{ csrf_field() }}

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

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Register</button>
					</div>

					@include ('layouts.errors')
				</form>
			</div>
		</div>

	</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script type="text/javascript" src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>

</body>
</html>
