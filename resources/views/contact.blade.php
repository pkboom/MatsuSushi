@extends('layouts.master')

@section('content')
<div class="container" >
	<div class="row location">
		<div class="col">
			<h6>LOCATION</h6>
			<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/view?zoom=17&center=44.3065%2C-78.3088&key=AIzaSyAA3ikuYTSKZPPXVWgAOgIlSoGJKpviLgw" allowfullscreen></iframe>
		</div>        
	</div>
	<div class="row contact">
		<div class="col">
			<h6>CONTACT</h6>
			<p>
				<span style="font-weight; ">Address:</span> 107 Hunter St. East Suite 102 Peterborough, Ontario, Canada <br>
				<span style="font-weight; ">Tel:</span> (705) 760-9484
			</p>
		</div>        
	</div>

	<div class="row operation">
		<div class="col">
			<h6>OPERATION</h6>
			<p>
				<span style="font-weight: 400">OPEN:</span> Mon-Sun 11:30 AM ~ 10:00 PM<br >
				<span style="font-weight: 400">CLOSED:</span> Monday of 2nd Week Every Month<br >
				<span style="font-weight: 400">HOLIDAY CLOSURES:</span> 12/25, 1/1
			</p>
		</div>        
	</div>
</div><!-- /.container -->
@endsection('content')
