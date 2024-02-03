@extends("back-end.includes.layouts.main")  
@section('page-title', 'Components')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Components</h3>
        </div>
        <div class="box-body">
            <component-manager></component-manager>
        </div>
      </div>
@endsection
