@extends('admin.master')

@section('content')
	<div class="container">
		<form method="POST" action="/upload" enctype="multipart/form-data">
			{{ csrf_field() }}
	
			<div class="form-group">
				<p>20 files allowed per upload</p>
				<label for="images"></label>
				<input type="file" class="form-control" id="images" name="images[]" required multiple>
			</div>
	
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Upload Image</button>
			</div>
	
		</form>
		@include ('layouts.errors')
	</div>
@endsection

