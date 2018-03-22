@extends('layouts.sartre')

@section('content')

	<div class="accordion style-2" data-toggle-icon="" data-toggle-multiple="">
		<ul>
			<li class="active">
				<div id="accordion-2-book-1" class="no-transition" style="height: auto;">
					<div class="accordion-content">
						<p class="lead mb-20">Books</p>
					</div>
				</div>
			</li>

			@foreach($books as $book)

				<li>
					<a href="#accordion-2-book-{{$book->id}}"><span class="icon-plus"></span>{{$book->name}}</a>

					<div id="accordion-2-book-{{$book->id}}">
						<div class="accordion-content">
							<a href="#" data-content="inline" data-aux-classes="tml-message-modal" data-modal-width="600" data-lightbox-animation="fadeIn" class="lightbox-link button bkg-theme bkg-hover-theme color-white color-hover-white">Quiz</a>

							<p class="lead mb-20">Lessons</p>

							@foreach($book->lessons as $lesson)

								<a href="{{ url('/lesson/'.$lesson->id) }}"><p/>{{$lesson->name}}</p></a>

							@endforeach
						</div>
					</div>
				</li>

			@endforeach
		</ul>
	</div>

@endsection
