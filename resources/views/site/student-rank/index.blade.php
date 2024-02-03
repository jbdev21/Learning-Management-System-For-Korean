@extends('layouts.website')

@section('content')
        <div style="position:relative" class="text-center">
                <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">Student Rank</h1>
                <img src="/images/index/banners/library.jpg" alt="">
        </div>
        <div class="container pt-5 pb-5 table-responsive">
            
            @foreach($ranks as $rank)
                <div class="student-rank-list">
                    <div class="date-div">
                        <div class="month">{{ date('M', strtotime($rank['month'])) }}</div>
                        <div class="year">{{ date('Y', strtotime($rank['month'])) }}</div>
                    </div>
                    <div class="details">
                        @foreach($rank['ranks'] as $student)
                            <h1>
                                @if($student['rank'] == 1)
                                    <img src="/images/index/first-medal.png" alt="">
                                @else
                                    <img src="/images/index/2nd-medal.png" alt="">
                                @endif
                                {{ $student['student'] }}</h1>
                        @endforeach
                    </div>
                </div>
            @endforeach
                    
            {{ $ranks->appends(['month' => Request::get('month')])->links() }}
                             
        </div>
@endsection
