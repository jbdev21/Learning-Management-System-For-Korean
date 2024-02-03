@extends("student.includes.layouts.main")  
@section('content')
    <div class="container-fluid col-md-8 col-lg-8 col-sm-offset-2">
         <div class="row">
            <div class="col-sm-6">
                <br>
                <br>
                <h1>Puzzle</h1>
                    <br>
            </div>
            <div class="col-sm-6 text-right">
                <img src="/images/index/icon_puzzle.png" alt="">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('student.puzzle.index') }}" class="btn btn-warning"><i class="fa fa-ban"></i> Back</a>

            </div>
            <div class="col-sm-6 text-right">
                {{-- <a href="" class="btn btn-warning" style="min-width: 100px"><i class="fa fa-arrow-left"></i> Prev</a> --}}
                @if(Request::segment(4) < 12)
                <a href="{{ route('student.puzzle.show',[ $category, (Request::segment(4) + 1)  < 10 ? "0" . (Request::segment(4) + 1) : Request::segment(4) + 1 ]) }}" class="btn btn-warning" style="min-width: 100px"><i class="fa fa-arrow-right"></i> Next</a>
                @endif
                <a href="{{ route('download', ['f' => $category. '/'.  Request::segment(4).'.pdf']) }}" class="btn btn-warning" style="min-width: 100px"><i class="fa fa-download"></i> Download</a>
            </div>
        </div>
        <h2 class="text-center">{{ ucwords(str_replace('_', ' ', $category)) }} {{ Request::segment(4) }}</h2>

        <div class="text-center">
            <div>
                <img src="/img/word_bank.png" alt="">
            </div>
           
            <h3 class="text-center quiz-hints">
                {{-- <i class="fa fa-quote-left" aria-hidden="true"></i> --}}
                "&nbsp;&nbsp;{!! str_replace(' ', '&nbsp;&nbsp;&nbsp;', config('puzzles.word_of_the_past.hints.' . request()->segment(4))) !!}&nbsp;&nbsp;"
                {{-- <i class="fa fa-quote-right" aria-hidden="true"></i> --}}
            </h3>
            {{-- <img src="/images/puzzle-hints/hint{{ request()->segment(4) }}.png"> --}}
        </div>

        <div class="table-responsive">
            <div id="puzzle-wrapper"><!-- crossword puzzle appended here --></div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .quiz-hints{
            position: relative;
            display:inline-block;
        }

        .quiz-hints .fa-quote-left{
            position: absolute;
            left: -100px;
            top:0px;
        }
        .quiz-hints .fa-quote-right{
            position: absolute;
            right: -100px;
            top:0px;
        }
    </style>
@endpush
@push('scripts')
    <script>
        axios.get('{{ Request::url() }}')
            .then(response => {
                $('#puzzle-wrapper').crossword(response.data);
            })
            .catch(error => {
                console.log(error)
            })
    </script>
@endpush