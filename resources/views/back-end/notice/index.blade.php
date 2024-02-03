@extends("back-end.includes.layouts.main")  
@section('page-title', 'Notice')
@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ Request::get('type') ? ucfirst(Request::get('type')) : 'Notice'}}</h3>
        </div>
        <div class="box-body">
            <div class="text-right">
                <a href="{{ route('back-end.notice.create', ['type' => Request::get('type') ?? 'notice']) }}" class="btn btn-warning"><i class="fa fa-plus"></i> Create</a>
                <button class="btn btn-danger" id='delete-all-btn'><i class="fa fa-trash"></i> Delete</button>
            </div>
         
            <div class='p-4'>
                <form action="{{ route('back-end.notice.destroy', 0) }}" method="POST" id="delete-all-form">
                    @method('DELETE') @csrf
                    <div class="table-responsive">
                    {!! $html->table() !!}
                    </div>
                </form>
            </div>

        </div>
      </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
    {!! $html->scripts() !!}
@endpush