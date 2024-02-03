@extends("back-end.includes.layouts.main")  

@section('page-title', ' Subjects')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Subjects</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                             <form action="{{ route('back-end.subject.update', $subject->id)}}" method="POST" >  
                                @csrf
                                @method('PUT')
                                <p>
                                    <label for="">Abbreviation *</label>
                                    <input type="text" name='abbreviation' value="{{ $subject->abbreviation }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Name</label>
                                    <input type="text" name='name' value="{{ $subject->name }}" class="form-control">
                                </p>
                                <p>
                                    <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('back-end.subject.index') }}" class="btn btn-default btn-md rounded-0"><i class="fa fa-ban"></i> Back</a>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-sm-8">

                </div>
            </div>
           
        </div>
      </div>
@endsection

