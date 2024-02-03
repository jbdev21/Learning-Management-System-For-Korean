@if (count($errors) > 0)
<div class="callout callout-danger">
    <h4>Opz!</h4>
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif