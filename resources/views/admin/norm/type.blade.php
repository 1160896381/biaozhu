@extends('_layouts.admin')

@section('contentAdmin')

<div id="page-wrapper">
	{{--
	<ul class="nav nav-tabs">
		@for ($i = 0; $i < 10; $i++)
			@if ($i == 0) 
				<li class="active"><a href="#tab1" data-toggle="tab">{{ $types[$i] }}</a></li>
			@else
				<li><a href="#tab{{ $i+1 }}" data-toggle="tab">{{ $types[$i] }}</a></li>			
			@endif
		@endfor
	</ul>

	<div class="tab-content">
		@for ($i = 0; $i < 10; $i++)
			@if ($i == 0) 
				<div class="tab-pane active" id="tab1">
			  		<p>I'm in Section 1.</p>
				</div>
			@else
				<div class="tab-pane" id="tab{{ $i+1 }}">
				  	<p>Howdy, I'm in Section 2.</p>
				</div>
			@endif
		@endfor
	</div>
	--}}
</div>

@endsection