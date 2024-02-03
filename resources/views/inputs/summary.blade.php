<div class="inputs-container">
    @if(isset($data['summary']))
        @forelse($data['summary'] as $formData)
            <div class="panel   @if($formData['writer_type'] == 'student') panel-primary @else panel-default @endif  form-writings">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-8">
                         @if(isset($formData['writer_type'])) {{ ucfirst($formData['writer_type']) }} @endif
                        </div>
                        <div class="col-xs-4  text-right">
                            Date: {{ date('Y-m-d H:i', strtotime($formData['date_time'])) }}

                            @auth
                                @if(auth()->user()->type != 'student')
                                    &nbsp;
                                    <a href="#" class="delete-writing text-danger" data-uri="{{ route('delete.writing', $formData['id']) }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="panel-body form-writings">
                    @if(isset($formData['errors']))
                        <div class="row">
                            <div class="col-xs-8 grammar-text form24">
                                {!! nl2br($formData['summary']) !!}
                            </div>
                            <div class="col-xs-4 form24">
                                <label for="">Suggestions</label>
                                @foreach($formData['errors'] as $index => $errorList)
                                    <div class="grammar-errors">
                                        <dl>
                                            <dt style="color:#ff1818;">{{ $index }}</dt>
                                            <dd>
                                                @for($i = 0; $i < count($errorList); $i++)
                                                    <span class="text-muted">
                                                        {{ str_replace(',', ', ', $errorList[$i]) }}
                                                    </span>
                                                @endfor
                                            </dd>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="form24">
                            {!!  nl2br($formData['summary']) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <h4 class="text-center">
                No Writings Yet.
            </h4>
        @endforelse
    @else
        <h4 class="text-center text-muted">
            - No Writings Yet -
        </h4>
    @endif

    @auth
        @if(Auth::user()->type == "student")
                <input type="hidden" name="form[input]" value="summary">
                <input type="hidden" name="form[mode]" value="stacked">
                <div style="background-image: url('/images/bg/writing.jpg'); background-size:cover; background-repeat:no-repeat; padding:20px 230px 10px 70px;">
                    <textarea name="form[data][summary]" cols="30" rows="11" class='form-control no-shadow' style="background:transparent !important; font-size:24px; resize:none">
                        @if(!isset($data['summary']))
                            {{ strip_tags(nl2br($data['default_value'])) }}
                        @endif
                    </textarea>
                </div>
        @endif
    @endauth
    @auth
        @if(Auth::user()->type == "teacher" || Auth::user()->type == "administrator" || Auth::user()->type == "sub-administrator")
            <br>
            <input type="hidden" name="form[input]" value="summary">
            <input type="hidden" name="form[mode]" value="stacked">
            @if(isset($data['summary']))
                    <grammar-component text="{!! $data['summary'][count($data['summary']) - 1]['summary'] !!}" api="yfXYXGanjgRAW4oW"></grammar-component>  
            @endif
        @endif
    @endauth
</div>

@push('styles')
    <style>
        .no-shadow:focus{
            outline:none;
            box-shadow:none;
        }

          .no-shadow{
            outline:none;
            box-shadow:none;
            border:0px;
            line-height:1.8em;
        }
    </style>
@endpush
