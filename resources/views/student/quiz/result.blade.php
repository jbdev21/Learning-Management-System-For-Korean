@extends("student.includes.layouts.main")
@section('content')
        <br>
        <div class=" box with-shadow mb-5">
            <div class="row">
                <div class="col-sm-4 text-right">
                    <canvas  id="chartContainer" ></canvas>
                </div>
                <div class="col-sm-8">
                    <div class="p-sm bg-white">
                        <img align="left" style="height: 300px; width:auto; margin-right:15px;" src="{{ $quiz->getThumbnail() }}" class="img-responsive" alt="">
                        <h3>{{ $quiz->name }}</h3>
                        <p>
                            {!! nl2br(Str::limit($quiz->details, 150)) !!}
                        </p>
                        <h3>Score: {{  $examination->quizScore()  }}</h3>

                        <a class="btn btn-lg btn-primary" href="{{ route('student.quiz.show', $quiz->code) }}">Play Again</a>
                        <a class="btn btn-lg btn-primary" href="{{ route('student.quiz.index') }}?category={{ Request::get('category') }}&q={{ Request::get('q') }}">Back</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="box mt-0" style='margin-top:0px;'>
            <ol>
                @foreach($questions as $question)
                    <li class="question-item" id="question-{{ $question->id }}" style="margin-bottom:10px">
                        <div class='mb-4'>
                            @if(optional($question->userAnswer(Auth::user()->id, $examination->id))->correct)
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
                                        <td>: {{ optional($question->userAnswer(Auth::user()->id, $examination->id))->answer }}</td>
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
                        {{  $examination->quizScore('correct')  }}, {{  $examination->quizScore('correct') - $quiz->questions()->count()  }}
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
