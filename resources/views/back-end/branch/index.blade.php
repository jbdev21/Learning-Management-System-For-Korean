@extends("back-end.includes.layouts.main")  
@section('page-title', 'Branches')
@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Branch</h3>
        </div>
        <div class="box-body">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" style="border-top-right-radius: 0px !important;border-bottom-right-radius: 0px !important;" placeholder="Search...">
                        <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" type="button">Search</button>
                        </span>
                    </div><!-- /input-group -->
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        <a href="{{ route('back-end.branch.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
                        <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                </div>
            </div>
           
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll" ></th>
                        <th>Name</th>
                        <th>Domain</th>
                        <th>Fax</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Reg. #</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                    <tr>
                        <td><input type="checkbox" name="item_checked[]" value="{{ $branch->id }}" ></td>
                        <td>{{ $branch->center_name }}</td>
                        <td>{{ $branch->domain }}</td>
                        <td>{{ $branch->fax_number }}</td>
                        <td>{{ $branch->contact_number }}</td>
                        <td>{{ $branch->email_address }}</td>
                        <td style="width:200px;">{{ $branch->address }}</td>
                        <td>{{ $branch->registration_number }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle tex-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-gear"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    {{-- <li><a href="{{ route('back-end.branch.show', $branch->id) }}" ><i class="fa fa-eye"></i> Details</a></li> --}}
                                    <li><a href="{{ route('back-end.branch.edit', $branch->id) }}" ><i class="fa fa-pencil"></i> Edit</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
                    {{-- {!! $html->table() !!} --}}
        </div>
      </div>
@endsection

{{-- @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
    {!! $html->scripts() !!}
@endpush --}}