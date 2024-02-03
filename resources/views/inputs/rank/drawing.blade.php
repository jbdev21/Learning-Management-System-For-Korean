<div class="inputs-container">
    <input type="hidden" name="drawing[input]" value="drawing">
	<input type="hidden" name="drawing[mode]" value="edit-only">
    <label></label>
    <textarea style="display:none" name="drawing[data][generatedimage]" id="generatedImage">@if(isset($data['drawing'][0]['generatedimage'])){{ $data['drawing'][0]['generatedimage']}}@endif</textarea>
    {{-- <input type="text" name="drawing[data][generatedimage]" @if(isset($data['drawing'][0]['generatedimage'])) value="{{ $data['drawing'][0]['generatedimage']}}" @endif id="generatedImage"> --}}
    @if(isset($data['drawing'][0]['generatedimage']))
        <br>
        Date Updated: {{  date('Y-m-d H:i', strtotime($data['drawing'][0]['date_time'])) }}
        <img  src="{{ $data['drawing'][0]['generatedimage'] }}" alt=""  class="img img-responsive">
    @endif

    <br>
</div>
