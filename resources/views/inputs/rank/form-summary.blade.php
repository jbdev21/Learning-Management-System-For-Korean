<div class="inputs-container">
      @if(isset($data['form']))
        @forelse($data['form'] as $formData)
            <div class="panel   @if($formData['writer_type'] == 'student') panel-primary @else panel-default @endif  form-writings">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-8">
                         @if(isset($formData['writer_type'])) {{ ucfirst($formData['writer_type']) }} @endif
                        </div>
                        <div class="col-xs-4  text-right">
                            Date: {{ $formData['date_time'] }}
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
                                <label for="">Errors</label>
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