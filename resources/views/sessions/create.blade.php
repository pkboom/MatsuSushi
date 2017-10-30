<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Sign In</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<!-- Custom styles for this template -->
	<link href="/css/app.css" rel="stylesheet">
</head>

<body>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-8">
				<h1 class="register-head">Sign In</h1>
				<form method="POST" action="/login">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>

					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Sign In</button>
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
