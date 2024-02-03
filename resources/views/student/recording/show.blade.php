@extends("student.includes.layouts.main")  
@section('content')
    <div class="container">
        <div style="margin-bottom:10px;">
            <a href="{{ route('student.recording.index') }}" class="btn btn-warning btn-md"><i class="fa fa-ban"></i> Back</a>
        </div>
      
        <div class="box" style="margin:0px;">
            <div class="pull-right">
                @if(Storage::exists($recording->recording))
                    <div class="gap-example" style="min-width:300px; width:300px;">
                        <audio>
                            <source src="{{ Storage::url($recording->recording) }}" type="audio/mpeg">
                        </audio>
                    </div>
                @else
                    <div class="text-danger">
                        Audio File is not found
                    </div>
                @endif
            </div>
            <h1 style="margin:0px;">{{ $recording->title }}</h1>
            <small>- <i class="fa fa-calendar"></i> {{ $recording->created_at->format('Y-m-d H:i') }}</small>
            <br>
            <br>
            {!! nl2br($recording->script) !!}
        </div>
        
        <br>
        <div class="">
            <comment-component item="{{ $recording->id }}" model="recording"></comment-component>
        </div>

    </div>
@endsection



@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/greghub/green-audio-player/dist/css/green-audio-player.min.css">
    <style>
        .controls__total-time{
            display:none !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/greghub/green-audio-player/dist/js/green-audio-player.min.js"></script>
    <script>
        new GreenAudioPlayer('.gap-example');
    </script>
@endpush