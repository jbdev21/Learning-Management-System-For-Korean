@extends("back-end.includes.layouts.main")  
@section('page-title', 'Grammar')
@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Grammar</h3>
        </div>
        <div class="box-body">
            <div class="text-right">
                <a href="{{ route('back-end.grammar.create') }}" class="btn btn-warning" style="margin-top: 5px;"><i class="fa fa-plus"></i> Create</a>
            </div>
         
            <div class='p-4'>
                {!! $html->table() !!}
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