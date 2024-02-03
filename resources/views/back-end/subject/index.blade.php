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
                            <form action="{{ route('back-end.subject.store')}}" method="POST" >  
                                @csrf
                                <p>
                                    <label for="">Abbreviation *</label>
                                    <input type="text" name='abbreviation' value="{{ old('abbreviation') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Name</label>
                                    <input type="text" name='name' value="{{ old('name') }}" class="form-control">
                                </p>
                                <p>
                                    <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-sm-8 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Abbreviation</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                                <tr id="item-{{ $subject->id }}">
                                    <td width="150px">{{ $subject->abbreviation }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td class='text-right'>
                                        <a class='btn btn-warning btn-xs' href="{{ route('back-end.subject.edit', $subject->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                                        <button data-uri="{{ route('back-end.subject.destroy', $subject->id) }}" data-remove="#item-{{ $subject->id }}"  class='btn btn-danger btn-xs delete-item' ><i class="fa fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
           
        </div>
      </div>
@endsection

