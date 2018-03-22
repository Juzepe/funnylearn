@extends('layouts.sartre')

@section('content')

	<div class="accordion style-2" data-toggle-icon="" data-toggle-multiple="">
		<ul>
			<li class="active">
				<div class="no-transition" style="height: auto;">
					<div class="accordion-content">
						<p class="lead mb-20">{{$lesson->name}}</p>
					</div>
				</div>
			</li>

			<li class="active">
				<div class="no-transition" style="height: auto;">
					<div class="accordion-content">
						<a href="{{ url('/lesson/'.$lesson->id.'/words') }}"><p/>Words</p></a>
					</div>
				</div>
			</li>
		</ul>
	</div>

@endsection
