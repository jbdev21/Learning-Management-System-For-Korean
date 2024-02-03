<div  class="inputs-container">
    @forelse($data[$componentid]['for-verb-form'] as $verbForm)
        <p>
            <label for="">Two things that happened in the book</label>
            <div class="row">
                <div class="col-xs-6">
                    <textarea rows="5" class="form-control" placeholder="Write Here">  @if(isset($verbForm['happen-first'])) {{ $verbForm['happen-first']}} @endif</textarea>
                </div>
                <div class="col-xs-6">
                    <textarea  rows="5" class="form-control" placeholder="Write Here"> @if(isset($verbForm['happen-end'])) {{ $verbForm['happen-end']}} @endif</textarea>
                </div>
            </div>
        </p>
        <br>
        <p>
            <label for="">Three VERBS in the book</label>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" name="for-verb-form[data][first-verb]"  class="form-control input-lg"  @if(isset($verbForm['first-verb'])) value="{{ $verbForm['first-verb']}}" @endif placeholder="Write Here">
                </div>
                <div class="col-xs-4">
                    <input type="text" name="for-verb-form[data][second-verb]"  class="form-control input-lg" @if(isset($verbForm['second-verb'])) value="{{ $verbForm['second-verb']}}" @endif placeholder="Write Here">
                </div>
                <div class="col-xs-4">
                    <input type="text" name="for-verb-form[data][third-verb]"  class="form-control input-lg" @if(isset($verbForm['third-verb'])) value="{{ $verbForm['third-verb']}}" @endif placeholder="Write Here">
                </div>
            </div>
        </p>
    
        <br>
        <p>
            <label for="">Write what happens at the end of the story</label>
            <textarea rows="8" class="form-control" placeholder="Write Here"> @if(isset($verbForm['end-of-story'])) {{ $verbForm['end-of-story']}} @endif</textarea>
        </p>
    @endforeach
</div>




