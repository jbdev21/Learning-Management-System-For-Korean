<div  class="inputs-container">
    <input type="hidden" name="for-verb-form[input]" value="for-verb-form">
	<input type="hidden" name="for-verb-form[mode]" value="edit-only">
    @if(isset($data['skimming'][0]['date_time']))Date Updated: {{  date('Y-m-d H:i', strtotime($data['for-verb-form'][0]['date_time'])) }} @endif
    <p>
        <label for="">Two things that happened in the book</label>
        <div class="row">
            <div class="col-xs-6">
                <textarea name="for-verb-form[data][happen-first]" style="resize: none" rows="5" class="form-control  input-lg" placeholder="Write Here">  @if(isset($data['for-verb-form'][0]['happen-first'])) {{ $data['for-verb-form'][0]['happen-first'] }} @endif</textarea>
            </div>
            <div class="col-xs-6">
                <textarea name="for-verb-form[data][happen-end]" style="resize: none" rows="5" class="form-control  input-lg" placeholder="Write Here"> @if(isset($data['for-verb-form'][0]['happen-end'])) {{ $data['for-verb-form'][0]['happen-end'] }} @endif</textarea>
            </div>
        </div>
    </p>
    <br>
    <p>
        <label for="">Three VERBS in the book</label>
        <div class="row">
            <div class="col-xs-4">
                <input type="text" name="for-verb-form[data][first-verb]"  class="form-control input-lg"  @if(isset($data['for-verb-form'][0]['first-verb'])) value="{{ $data['for-verb-form'][0]['first-verb']}}" @endif placeholder="Write Here">
            </div>
            <div class="col-xs-4">
                <input type="text" name="for-verb-form[data][second-verb]"  class="form-control input-lg" @if(isset($data['for-verb-form'][0]['second-verb'])) value="{{ $data['for-verb-form'][0]['second-verb']}}" @endif placeholder="Write Here">
            </div>
            <div class="col-xs-4">
                <input type="text" name="for-verb-form[data][third-verb]"  class="form-control input-lg" @if(isset($data['for-verb-form'][0]['third-verb'])) value="{{ $data['for-verb-form'][0]['third-verb']}}" @endif placeholder="Write Here">
            </div>
        </div>
    </p>
    <br>
    <p>
        <label for="">Write what happens at the end of the story</label>
        <textarea name="for-verb-form[data][end-of-story]" rows="8" style="resize: none" class="form-control input-lg" placeholder="Write Here"> @if(isset($data['for-verb-form'][0]['end-of-story'])) {{ $data['for-verb-form'][0]['end-of-story']}} @endif</textarea>
    </p>
    {{-- <p>
        <br>
        <br>
        <br>
        <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button>
    </p> --}}
</div>




