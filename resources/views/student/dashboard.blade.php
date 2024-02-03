@extends("student.includes.layouts.main")  
@section('content')
<br>
<br>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default dashboard-panel" style="background-image: url(http://gwkyh7425.cafe24.com/img/bg/img_gate01.png)">
                    <div class="panel-body">
                        <a href="{{ route('student.essay.index') }}">
                            <h1>
                                ESSAY
                            </h1>
                            <small>영어 논술</small>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default dashboard-panel" style="background-image: url(http://gwkyh7425.cafe24.com/img/bg/img_gate02.png)">
                    <div class="panel-body">
                    <a href="{{ route('library.index') }}">
                        <h1>
                            LIBRARY
                        </h1>
                        <small>
                            영어도서관
                        </small>
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default dashboard-panel" style="background-image: url(http://gwkyh7425.cafe24.com/img/bg/img_gate03.png)">
                    <div class="panel-body">
                    <a href="https://gwenglishacademy.com/index.php/notice?type=grammar">
                        <h1>
                            GRAMMAR
                        </h1>
                        <small>영문법</small>
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default dashboard-panel" style="background-image: url(http://gwkyh7425.cafe24.com/img/bg/img_gate04.png)">
                    <div class="panel-body">
                        <h1>
                            ASSESSMENT
                        </h1>
                        <small>학습 평가 • 관리(모니터링)</small>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection