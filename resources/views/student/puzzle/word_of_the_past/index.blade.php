@extends("student.includes.layouts.main")  
@section('content')
    <div class="container-fluid col-md-8 col-lg-8 col-sm-offset-2">
            <div class="row">
                <div class="col-sm-6">
                    <br>
                    <br>
                    <h1>Puzzle</h1>
                     <br>
                <form id="category-selector">
                    <select name="category" onchange="$('#category-selector').submit()" id="" class="form-control">
                        @foreach($categories as $category)
                            <option @if($defaultCategory == $category) selected @endif value="{{ $category }}">{{ ucwords(str_replace('_', ' ', $category)) }}</option>
                        @endforeach
                    </select>
                </form>
                </div>
                <div class="col-sm-6 text-right">
                    <img src="/images/index/icon_puzzle.png" alt="">
                </div>
            </div>

            <table class="table">
                @foreach($items as $item)
                    <tr>
                        <td><b>{{ ucwords(str_replace('_', ' ', $defaultCategory)) }} {{ str_replace('.php', '', $item) }}</b></td>
                        <td class="text-right"><a class="btn btn-sm btn-warning" href="{{ route('student.puzzle.show',[ $defaultCategory, str_replace('.php', '', $item)]) }}">Go Now</a></td>
                    </tr>
                @endforeach
            </table>
    </div>
@endsection
