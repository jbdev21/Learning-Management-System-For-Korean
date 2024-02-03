@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible mt-1 mb-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('success') }}
    </div>
@endif