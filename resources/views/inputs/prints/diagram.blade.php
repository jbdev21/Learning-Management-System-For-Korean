<div class="inputs-container">
    @if(\File::exists(public_path('images/diagram-samples/' . $activecomponent->name . ".jpg")))
        <div class="text-center">
            <center>
                <label for="">Sample</label>
                <img src="/images/diagram-samples/{{$activecomponent->name}}.jpg" class="img img-responsive img-center-block" alt="">
            </center>
        </div>
	    <hr>
	@endif
	<div class="clearfix"></div>
	<br>
    <div id="diagram" class="text-center">
		@if(isset($data[$componentid]['diagram'][0]['generatedDiagram']))
            <div class="text-left">
                Date Updated: {{ $data[$componentid]['diagram'][0]['date_time'] }}
            </div>
			<br>
            {!! $data[$componentid]['diagram'][0]['generatedDiagram'] !!}
		@else
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="1px" height="1px" viewBox="-0.5 -0.5 1 1" content="&lt;mxfile host=&quot;www.draw.io&quot; modified=&quot;2020-03-04T18:28:47.020Z&quot; agent=&quot;Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36&quot; etag=&quot;yoGeY7tbEPeoDeDV40Yg&quot; version=&quot;12.7.9&quot;&gt;&lt;diagram id=&quot;I14GIMS1cu3KKKX1ZYix&quot; name=&quot;Page-1&quot;&gt;ddHBEoIgEADQr+Gu4JSdzerSyUNnRjZhBl0HabS+Ph0gY6wTy2NhWSCsaKez4b28ogBNaCImwo6E0jTfHeZhkaeTbJc5aIwSPmmFSr3AY+L1oQQMUaJF1Fb1MdbYdVDbyLgxOMZpd9Rx1Z43sIGq5nqrNyWsdJrT/eoXUI0MldPQcMtDsu9kkFzg+EWsJKwwiNZF7VSAXh4vvIvbd/qz+rmYgc7+2DAH69nzJPohVr4B&lt;/diagram&gt;&lt;/mxfile&gt;"><defs/><g/></svg>
		@endif
	</div>
</div>

@push('scripts')
    <script>
        $("svg").css("width","100%");
    </script>
@endpush

