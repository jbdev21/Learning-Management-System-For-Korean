<div class="inputs-container">
    <label>Draw a picture of the cover of your book.</label>
    <div>
        Date Updated: {{ $data[$componentid]['drawing'][0]['date_time'] }}
        <div class="text-center">
        <img  src="{{ $data[$componentid]['drawing'][0]['generatedimage'] }}"  class="img-responsive center-block">
        </div>
    </div>
     
</div>


