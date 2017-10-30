@extends('admin.master')

@section('content')

<?php $admin_upload = "active"; ?>
<div id="app-upload">

	<upload-image-popup v-show="uploaded"></upload-image-popup>

	<form method="POST" action="/admin/uploadImage" enctype="multipart/form-data">
		{{ csrf_field() }}

		<div class="form-group">
			<p>20 files allowed per upload</p>
			<input type="file" class="form-control" id="image" name="image[]" required multiple>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary" @click="uploaded = true">Upload Image</button>
		</div>

	</div>
	@include ('layouts.errors')
</form>

@endsection('content')

