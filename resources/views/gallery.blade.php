@extends('layouts.master')

@section('content')
	<?php $nav_gallery = 'active'; ?>

	<div class="container">
		<div id="lightgallery">
			@foreach ($photos as $photo)
			<a href="{{ asset('storage/' . $photo) }}">
				<img src="{{ asset('storage/' . $photo) }}" > 
			</a>
			@endforeach
		</div>
		<div class="row justify-content-center pagination-container">
			<div class="col-md-auto">
				<ul class="pagination">
					@if ($displayPage == 1)
						<li class="disabledLink"> < </li>
					@else
						<li><a href="{{ $displayPage - 1 }}"> < </a></li>
					@endif
					@foreach ($pages as $page)
						@if ($displayPage == $page)
							<li class="active"><a href="{{ url('gallery/pages/'.$page) }}">{{ $page }}</a></li>
						@else
							<li><a href="{{ url('gallery/pages/'.$page) }}">{{ $page }}</a></li>
						@endif
					@endforeach
					@if ($displayPage == $lastPage)
						<li class="disabledLink"> > </li>
					@else
						<li><a href="{{ url('gallery/pages/'. ($displayPage + 1)) }}"> > </a></li>
					@endif
				</ul>
				
			</div>
			
		</div>
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
