@extends('admin.master')

@section('content')
	<div class="container">
		<form method="POST" action="/admin/upload-image" enctype="multipart/form-data">
			{{ csrf_field() }}
	
			<div class="form-group">
				<p>20 files allowed per upload</p>
				<label for="image">
					<input type="file" class="form-control" id="image" name="image[]" required multiple>
				</label>
			</div>
	
			<div class="form-group">
				<button type="submit" class="btn btn-primary" @click="uploaded = true">Upload Image</button>
			</div>
	
		</form>
		@include ('layouts.errors')
	</div>
@endsection

