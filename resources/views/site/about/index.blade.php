@extends('layouts.website')

@section('content')
<div style="position:relative" class="text-center">
      <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">GW프로그램</h1>
      <img src="/images/bg/about.jpg" alt="">
</div>
</section>
    
 <section class="mb-5">
      <div class="container">
            <div class="modern-tab text-center">
                  <ul class="nav nav-tabs  nav-fill mt-2 mb-5" style="font-size: 19px; max-width: 420px; margin-left: 30%;">
                    <li class="nav-item">
                         <a class="nav-link btn-warning" href="#nav-home" style="color: #fff;">교수/학습철학</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link btn-primary" href="{{ route('about.template2')}}" style="color: #fff;">영어논술커리큘럼</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link btn-primary" href="{{ route('about.template3')}}" style="color: #fff;">영어에세이과정</a>
                    </li>
                  </ul>
            </div>
            <div class="tab-content">
              <div class="tab-pane show active">
                  <img src="/images/index/GW_teaching.png" class="img img-responsive" alt="">
              </div>
      </div>
</section>
@endsection
