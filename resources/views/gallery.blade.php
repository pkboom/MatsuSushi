@extends('layouts.master')

@section('content')
	<?php $nav_gallery = 'active'; ?>

	<div class="container">
		<div id="lightgallery">
			@foreach ($images as $image)
			<a href="{{ asset('storage/' . $image->filename) }}">
				<img src="{{ asset('storage/thumb/' . $image->filename) }}" > 
			</a>
			@endforeach
		</div>
		{{ $images->links() }}
	</div><!-- /.container -->
	
 	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/lightgallery.js/1.0.1/js/lightgallery.min.js"></script>
	<!-- justified Gallery -->
	<script src="/js/jquery.justifiedGallery.min.js"></script>
	<script type="text/javascript">
		lightGallery(document.getElementById('lightgallery')); 

		$("#lightgallery").justifiedGallery({
			rowHeight : 200,
			lastRow : 'nojustify',
			margins : 5
		});
	</script>
@endsection('content')
