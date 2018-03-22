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
		</ul>

		<br>

		@foreach($words as $word)

			<div class="row">
				<div class="column width-6">
					<div class="field-wrapper">
						<p class="meanings" word-id="{{$word->id}}" title="{{$word->word}}">{{$word->meaning}}</p>
					</div>
				</div>

				<div class="column width-6">
					<div class="field-wrapper">
						<input id="word-{{$word->id}}" type="text" class="form-lname form-element large" tabindex="2" onkeypress="check()">
					</div>
				</div>
			</div>

		@endforeach

		<button onclick="check()">Check</button>
	</div>

@endsection

@push('scripts')
<script>
	function check() {
		var meanings = document.getElementsByClassName('meanings');

		for (var i = meanings.length - 1; i >= 0; i--) {
			word_id = meanings[i].getAttribute("word-id");
			word = meanings[i].getAttribute("title");

			checked_word = document.getElementById('word-' + word_id).value;

			if (word != checked_word) {
				document.getElementById('word-' + word_id).style.border="1px solid red";
			} else {
				document.getElementById('word-' + word_id).style.border="1px solid blue";
			}
		}
	}
</script>
@endpush