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

                          @if(auth()->user()->type != 'student')
                              &nbsp; 
                              <a href="#" class="delete-writing" data-uri="{{ route('delete.writing', $formData['id']) }}">
                                  <i class="fa fa-trash"></i>
                              </a>
                          @endif
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


    <input type="hidden" name="letter[input]" value="letter">
    <input type="hidden" name="letter[mode]" value="stacked">


    @if(isset($hasInput) && $hasInput)
           @auth
              @if(Auth::user()->type == "student")
                <h2>
                    Letter
                </h2>
                <label for="">
                    Write a Letter to the Hero or Heroine in the Story
                </label> <br>
                <span class="text-muted">(이야기 속의 주인공에게 편지를 써보세요!)</span>
                  {{-- <div style="background-image: url('/images/bg/letter_background.jpg'); background-size:contain,cover; background-position:top; background-repeat:no-repeat; padding:20px 30px 10px 10px; height:200%"> --}}
                      <textarea name="letter[data][summary]" cols="30" rows="15" class='form-control no-shadow' style=" font-size:24px; resize:none; background-image: url('/images/bg/letter_background.jpg'); background-size:contain,cover; padding:20px 30px 50px 10px;"></textarea>
                  {{-- </div> --}}
              @endif
          @endauth
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
