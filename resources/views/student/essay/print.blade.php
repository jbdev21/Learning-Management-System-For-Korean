@extends("student.includes.layouts.print")  
@section('page-title', 'Book: '. $book->title)
@section('content')
        <div class="text-center" style="page-break-before:always; margin-top:350px">
            <h1 style="color:#20BACF; font-size:32px;" >{{ $book->title }}</h1>
            Series/Stage: {{ $book->type_name }} &nbsp;&nbsp;&nbsp; AR Level: {{ $book->ar_level }}
        </div>
        @foreach($components as $component)
            @foreach($component->children as $children)
                @foreach( $children->children as $activecomponent )
                    @if(auth()->user()->componentWritings($book->id, $activecomponent->id)->count())
                        @if(isset($data[$activecomponent->id]))
                            <div class="page-item" style="page-break-before:always" >
                                <div>
                                    <h1>
                                        {{ $activecomponent->parent->name }}
                                    </h1>   
                                    <div class="text-muted">
                                        {{ $activecomponent->name }}
                                        <br>
                                    </div>
                                </div>
                                <hr>
                                <div style="padding:0px 30px 0px 40px;" >
                                    @foreach($activecomponent->inputs as $input)
                                        @if( isset($data[$activecomponent->id][strtolower(\Str::slug($input))]))
                                            @include('inputs.prints.' . strtolower(\Str::slug($input)), ['componentid' => $activecomponent->id])
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <br/>
                        @endif
                    @endif
                @endforeach
            @endforeach
        @endforeach

@endsection

@push('scripts')
    <script>
     
            window.print();
     
        
    </script>
@endpush
