 <div class="inputs-container">
    	<input type="hidden" name="diagram[input]" value="diagram">
	<input type="hidden" name="diagram[mode]" value="edit-only">
	<input type="hidden" id="generatedDiagram" name="diagram[data][generatedDiagram]" @if(isset($data['diagram'][0]['generatedDiagram'])) value="{{ $data['diagram'][0]['generatedDiagram']}}" @endif id="generatedDiagram">
	{{ str_replace(" / ", "_", $activecomponent->name)  }}
	@if(\File::exists(public_path('images/diagram-samples/' . str_replace(" / ", "_", $activecomponent->name) . ".jpg")))
        <div class="text-center">
            <center>
			<div class="text-center mb-2">
				<a class='btn btn-primary btn-sm' type="button" role="button" data-toggle="collapse" data-target="#collapse-sample" aria-expanded="false" aria-controls="collapse-sample" > Show/Hide Sample</a>
				<br>
				<br>
			</div>
			<div class='collapse in' id='collapse-sample'>
				<div class="text-center">
					<a href="/images/diagram-samples/{{str_replace(" / ", "_", $activecomponent->name)}}.jpg" target="_blank"> See in Seperated Tab</a>
				</div>
				<img src="/images/diagram-samples/{{str_replace(" / ", "_", $activecomponent->name)}}.jpg" class="img img-responsive img-center-block" alt="">
			</div>
            </center>
        </div>
	<hr>
	@endif
	

	{{-- this is a fix for the issue in admin and teacher in showing the diagram editor --}}
	@auth
		@if(Auth::user()->type == "student")	
		<div class="row">
			<div class="col-sm-8">
				@if(Request::get('component') == 30)
					<label for="">Were the events or actions planned in a time? (시간에 따른 전개) </label> <br>
					<span class="text-muted">Draw the story by Time Signals!(Morning->Afternoon->Evening, etc)</span>
				@elseif(Request::get('component') == 31)
					<label for="">Were the events or actions planned in steps or stages? (사건의 연속)</label> <br>
					<span class="text-muted">Draw the story by Numbering of Steps!(①->②->③->④->⑤->⑥, etc)</span>
				@elseif(Request::get('component') == 32)
					<label for="">Did the actor get in a trouble? How did she or he get through it?(문제&해결)</label> <br>
					<span class="text-muted">Try to figure it out by when, where, who, what, how, why!</span>
				@elseif(Request::get('component') == 33)
					<label for="">
						Why was the events or actions happened? Why did the actor do so? <br>
						What did come after then? (원인&결과) 
					</label> <br>
					<span class="text-muted">Try to figure it out by when, where, who, what, how, why!</span>
				@elseif(Request::get('component') == 34)
					<label for="">
						Miscellaneous Organizers(기타) <br>
						If the story cannot fit with other graphic patterns, choose one of Miscellaneous Organizers 
					</label> <br>
					<span class="text-muted">Listing-up(목록) / Grouping(분류) / Ranking(순위) / Generalization-Evidence(일반화-증거, 정의),etc</span>
				@elseif(Request::get('component') == 66)
					<label for="">
						Plan to Write an Essay (에세이 쓰기 계획하기) 
					</label> <br>
					<span class="text-muted">문단(Paragraph) 과 에세이(Essay)의 특징을 이해하고 나의 에세이를 계획</span>
				@elseif(Request::get('component') == 67)
					<label for="">
						Plan to Write an Essay (에세이 쓰기 계획하기) 
					</label> <br>
					<span class="text-muted">문단(Paragraph) 과 에세이(Essay)의 특징을 이해하고 나의 에세이를 계획</span>
				
				@endif
			</div>
			<div class="col-sm-4">
				<a href="#" class="btn btn-default pull-right" onclick="edit()"><i class="fa fa-pencil"></i> Write / Edit </a>
			</div>
		</div>
		@endif
	@endauth
	
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
    
	<iframe id="iframe"></iframe>
	{{-- <div class="text-right">
	   	<br>
		<br>
		<br>
		<button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button>
	</div> --}}
</div>

@push('styles')
    <style>
		#diagram{
			padding:20px;
			border:5px dotted #ccc;
			min-height: 250px;
			overflow:auto;
		}
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
@push('scripts')
    <script>
       var editor = 'https://embed.diagrams.net/?embed=1&ui=min&spin=1&proto=json&configure=1';
		var initial = null;
		var name = null;

		function edit()
		{
			var elt = document.getElementById('diagram')
			var iframe = document.getElementById('iframe');
			$('#iframe').css('z-index', 2)
			$('#iframe').css('display', 'block')
			
			var close = function()
			{
				window.removeEventListener('message', receive);
				$('#iframe').css('z-index', 0)
				$('#iframe').css('display', 'none')
			};

			// var draft = localStorage.getItem('.draft-' + name);
			var draft = null;
						
			// if (draft != null)
			// {
			// 	draft = JSON.parse(draft);
							
			// 	if (!confirm("A version of this page from " + new Date(draft.lastModified) + " is available. Would you like to continue editing?"))
			// 	{
			// 		draft = null;
			// 	}
			// }
			
			var receive = function(evt)
			{
				if (evt.data.length > 0)
				{
					var msg = JSON.parse(evt.data);
					// If configure=1 URL parameter is used the application
					// waits for this message. For configuration options see
					// https://desk.draw.io/support/solutions/articles/16000058316
					if (msg.event == 'configure')
					{
						// Configuration example
						iframe.contentWindow.postMessage(JSON.stringify({action: 'configure',
							config: {
								defaultFonts: ["Humor Sans", "Helvetica", "Times New Roman"],
							}
							}), '*');
					}
					else if (msg.event == 'init')
					{
						if (draft != null)
						{
							iframe.contentWindow.postMessage(JSON.stringify({action: 'load',
								autosave: 1, xml: draft.xml}), '*');
							iframe.contentWindow.postMessage(JSON.stringify({action: 'status',
								modified: true}), '*');
						}
						else
						{
							// Avoids unescaped < and > from innerHTML for valid XML
							var svg = new XMLSerializer().serializeToString(elt.firstChild);

							iframe.contentWindow.postMessage(JSON.stringify({action: 'load',
								autosave: 1, xml: svg}), '*');
						}
					}
					else if (msg.event == 'export')
					{
						// Extracts SVG DOM from data URI to enable links
						var svg = atob(msg.data.substring(msg.data.indexOf(',') + 1));
						elt.innerHTML = svg;
						$('#generatedDiagram').val(svg)
						// localStorage.setItem(name, JSON.stringify({lastModified: new Date(), data: svg}));
						// localStorage.removeItem('.draft-' + name);
						draft = null;
						close();
					}
					else if (msg.event == 'autosave')
					{
						$('#generatedDiagram').val(msg.xml)
						// localStorage.setItem('.draft-' + name, JSON.stringify({lastModified: new Date(), xml: msg.xml}));
					}
					else if (msg.event == 'save')
					{
						iframe.contentWindow.postMessage(JSON.stringify({action: 'export',
							format: 'xmlsvg', xml: msg.xml, spin: 'Updating page'}), '*');
						// localStorage.setItem('.draft-' + name, JSON.stringify({lastModified: new Date(), xml: msg.xml}));
					}
					else if (msg.event == 'exit')
					{
						// localStorage.removeItem('.draft-' + name);
						draft = null;
						close();
					}
				}
			};

			window.addEventListener('message', receive);
			iframe.setAttribute('src', editor);
			document.body.appendChild(iframe);

		};
				
		function load()
		{
			initial = document.getElementById('diagram').innerHTML;
			start();
		};
		
		function start()
		{
			name = (window.location.hash.length > 1) ? window.location.hash.substring(1) : 'default';
			var current = localStorage.getItem(name);
		
			if (current != null)
			{
				var entry = JSON.parse(current);
				document.getElementById('diagram').innerHTML = entry.data;
			}
			else
			{
				document.getElementById('diagram').innerHTML = initial;
			}
		};
		
        {{-- load()
        window.addEventListener('hashchange', start); --}}
        // edit(document.getElementById('diagram'))
      
    </script>
@endpush
