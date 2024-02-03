@extends("back-end.includes.layouts.main")
@section('page-title', 'Books')
@section('content-header')
    <h1>
       Grammars
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="active">Grammars</li>
    </ol>
    <a href="{{ route('back-end.examination.index') }}" class="btn btn-warning mt-3">Back to List</a>
@endsection
@section('content')
        <div class=" box with-shadow mb-5 p-4">
            {{-- <img src="{{ $quiz->getThumbnail() }}" class="img-responsive" alt=""> --}}
            <div class="p-sm bg-white">
                <h3>{{ $quiz->name }}</h3>
                <p class="mb-3">
                    {!! nl2br(Str::limit($quiz->details, 150)) !!}
                </p>
                    <table>
                        <tr>
                            <td>Date of submit</td>
                            <td>: {{ $examination->created_at->format('Y-m-d h:iA') }}</td>
                        </tr>
                        <tr>
                            <td>Score</td>
                            <td>: {{  $examination->quizScore()  }}</td>
                        </tr>
                    </table>
            </div>


        </div>
        <div class="box mb-2" >
            <br>
            <ol>
                @foreach($questions as $question)
                    <li class="question-item" id="question-{{ $question->id }}" style="margin-bottom:10px">
                        <div class='mb-4'>
                            @if(optional($question->userAnswer($examination->user_id, $examination->id))->correct)
                                <span class="badge badge-success" style='background-color:green; padding:5px 5px; border-radius:50%'><i class="fa fa-check"></i></span>
                            @else
                                <span class="badge badge-success" style='background-color:red; padding:5px 6px; border-radius:50%'>
                                    <i class="fa fa-remove"></i>
                                </span>
                            @endif
                            {!!  $question->body !!}
                        </div>
                        <br>
                        <small class="mt-2 d-block">
                            <i>
                                <table>
                                    <tr>
                                        <td>Your Answer </td>
                                        <td>: {{ optional($question->userAnswer($examination->user_id, $examination->id))->answer }}</td>
                                    </tr>
                                    <tr>
                                        <td>Correct </td>
                                        <td>: {{ $question->answerText() }}</td>
                                    </tr>
                                    @if($question->explanation)
                                    <tr>
                                        <td>Explanation </td>
                                        <td>: {{ $question->explanation }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </i>
                        </small>
                        @if($question->type == "multiple")
                            <br>
                            <ul type="1">
                                @foreach($question->options as $option)
                                    <li> {{ $option  }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if(!$loop->last)
                        <hr>
                        @endif

                    </li>
                @endforeach
            </ol>
        </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script type="text/javascript">
        var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
                        {{  $examination->quizScore($quiz->id, 'correct')  }}, {{  $examination->quizScore($quiz->id, 'correct') - $quiz->questions()->count()  }}
					],
					backgroundColor: [
						'rgb(54, 162, 235)',
						'rgb(255, 99, 132)'
					],
					label: 'Result'
				}],
				labels: [
                    'Correct',
                    'Wrong'
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chartContainer').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
    </script>
@endpush
