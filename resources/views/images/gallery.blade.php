@extends('layouts.master')

@section('header')
 	<link href="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/css/lightgallery.css" rel="stylesheet">
 	<link rel="stylesheet" href="/css/justifiedGallery.min.css" />
@endsection

@section('content')
	<div class="container">
		<div id="lightgallery">
			@foreach ($images as $image)
				<a href="{{ asset('storage/' . $image->filename) }}">
					<img src="{{ asset('storage/thumbs/' . $image->filename) }}"> 
				</a>
			@endforeach
		</div>
		{{ $images->links() }}
	</div>
@endsection 

@section('javascript')
	<script src="https://cdn.jsdelivr.net/lightgallery.js/1.0.1/js/lightgallery.min.js"></script>
	<script src="/js/jquery.justifiedGallery.min.js"></script>
	
	<script type="text/javascript">
		lightGallery(document.getElementById('lightgallery')); 

		$("#lightgallery").justifiedGallery({
			rowHeight : 200,
			lastRow : 'nojustify',
			margins : 5
		});
	</script>
@endsection
