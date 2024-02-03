<div class="inputs-container">
    	<input type="hidden" name="diagram[input]" value="diagram">
	<input type="hidden" name="diagram[mode]" value="edit-only">
	<input type="hidden" id="generatedDiagram" name="diagram[data][generatedDiagram]" @if(isset($data['diagram'][0]['generatedDiagram'])) value="{{ $data['diagram'][0]['generatedDiagram']}}" @endif id="generatedDiagram">
	@if(\File::exists(public_path('images/diagram-samples/' . $activecomponent->name . ".jpg")))
        <div class="text-center">
            <center>
			<div class="text-center mb-2">
				<a class='btn btn-primary btn-sm' type="button" role="button" data-toggle="collapse" data-target="#collapse-sample" aria-expanded="false" aria-controls="collapse-sample" > Show/Hide Sample</a>
				<br>
				<br>
			</div>
			<div class='collapse in' id='collapse-sample'>
				<div class="text-center">
					<a href="/images/diagram-samples/{{$activecomponent->name}}.jpg" target="_blank"> See in Seperated Tab</a>
				</div>
				<img src="/images/diagram-samples/{{$activecomponent->name}}.jpg" class="img img-responsive img-center-block" alt="">
			</div>
            </center>
        </div>
	<hr>
	@endif

	<div class="clearfix"></div>
	<br>
	@if(isset($data['diagram'][0]['generatedDiagram']))
	<div class="text-left">
		Date Updated: {{  date('Y-m-d H:i', strtotime($data['diagram'][0]['date_time'])) }}
	</div>
	<br>
	@endif
    <div id="diagram" class="text-center">
		@if(isset($data['diagram'][0]['generatedDiagram']))
			{!! $data['diagram'][0]['generatedDiagram'] !!}
		@else
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="1px" height="1px" viewBox="-0.5 -0.5 1 1" content="&lt;mxfile host=&quot;www.draw.io&quot; modified=&quot;2020-03-04T18:28:47.020Z&quot; agent=&quot;Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36&quot; etag=&quot;yoGeY7tbEPeoDeDV40Yg&quot; version=&quot;12.7.9&quot;&gt;&lt;diagram id=&quot;I14GIMS1cu3KKKX1ZYix&quot; name=&quot;Page-1&quot;&gt;ddHBEoIgEADQr+Gu4JSdzerSyUNnRjZhBl0HabS+Ph0gY6wTy2NhWSCsaKez4b28ogBNaCImwo6E0jTfHeZhkaeTbJc5aIwSPmmFSr3AY+L1oQQMUaJF1Fb1MdbYdVDbyLgxOMZpd9Rx1Z43sIGq5nqrNyWsdJrT/eoXUI0MldPQcMtDsu9kkFzg+EWsJKwwiNZF7VSAXh4vvIvbd/qz+rmYgc7+2DAH69nzJPohVr4B&lt;/diagram&gt;&lt;/mxfile&gt;"><defs/><g/></svg>
		@endif
	</div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('svg').attr("class", "img img-responsive")
        });
    </script>
@endpush

@push('styles')
    <style>

        iframe {
			border:0;
			position:fixed;
			top:0;
			left:0;
			right:0;
			bottom:0;
			width:100%;
			height:100%;
			z-index:99999;
			display:none;
		}

		.list-group-item .active{
			z-index:1;
		}
    </style>
@endpush
