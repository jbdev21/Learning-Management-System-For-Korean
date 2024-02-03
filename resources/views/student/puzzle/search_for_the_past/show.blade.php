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
        <br>
        <div class="table-responsive">
            <div class="row">
                <div class="col-sm-6">
                    <div id="puzzle-container"></div>
                </div>
                <div class="col-sm-6">
                    <div class="puzzle-words">
                        <ul class="clearfix" id="wordlist">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/wordsearch.css">
    <style>
        .puzzle-words ul{
            list-style: none;
        }

        .puzzle-words ul li.word{
            float: left;
            width: 100%;
            line-height: 30px;
            margin-bottom: 20px;
        }
        .puzzle-words ul li.word span{ 
            font-size:18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .puzzle-words ul li .wordFound {
            text-decoration: line-through;
            color: green;
            font-size:28px !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="/js/wordfind.js"></script>
    <script src="/js/wordfindgame.js"></script>
    <script>
         axios.get('{{ Request::url() }}')
            .then(response => {
                var words = response.data.map(e => 
                    e.answer
                )

                response.data.map(e => {
                    var html = `<li class="word ${e.answer}" data-answer="${e.answer}">
                            <span>${e.word}</span>
                            <input type="text" class="form-control">
                        </li>`
                    $('#wordlist').append(html)
                })
                
                wordfindgame.create(words, '#puzzle-container', '#puzzle-words');
            })
            .catch(error => {
                console.log(error)
            })       
    </script>
@endpush