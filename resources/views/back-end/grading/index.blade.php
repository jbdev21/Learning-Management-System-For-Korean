@extends("back-end.includes.layouts.main")  
@section('page-title', 'Branches')
@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Grading</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.grading.store') }}" method="POST">
                                @csrf
                                <p>
                                    <label for="">Note</label>
                                    <textarea name="note" id="" rows="3" class="form-control"></textarea>
                                </p>
                                <p>
                                    <label for="">Type</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="accelerate">Accelerate</option>
                                        <option value="revert">Revert</option>
                                    </select>
                                </p>
                                <p>
                                    <button type="submit" class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-sm-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Note</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gradings as $grading)
                                <tr>
                                    <td>{{ $grading->created_at->format('M d, Y h:i:s A') }}</td>   
                                    <td>{{ ucfirst($grading->type) }}</td>   
                                    <td>{{ $grading->note }}</td>   
                                    <td></td>
                                </tr> 
                            @empty
                                <tr>
                                    <td class="text-center p-5" colspan="4">No history</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $gradings->links() }}
                </div>
            </div>
           
        </div>
      </div>
@endsection