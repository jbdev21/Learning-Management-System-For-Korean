@extends("back-end.includes.layouts.main")  
  

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Excercise</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($excercises as $excercise)
                        <tr>
                            <td>{{ $excercise->user->name }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td align="center" colspan="4"> No Excercise</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
           
        </div>
      </div>
@endsection

