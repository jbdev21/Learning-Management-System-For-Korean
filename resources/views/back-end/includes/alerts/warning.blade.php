@if(Session::has('warning'))
    <div class="alert alert-warning alert-dismissible mt-1 mb-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('warning') }}
    </div>
@endif