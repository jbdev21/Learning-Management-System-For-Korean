<div class="inputs-container">

    @if(isset($data['letter']))
      @forelse($data['letter'] as $formData)
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
                <div class="form24">
                    {!!  nl2br($formData['summary']) !!}
                </div>
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
