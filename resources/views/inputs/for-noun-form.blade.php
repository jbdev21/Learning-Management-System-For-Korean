<div  class="inputs-container">
    <input type="hidden" name="for-noun-form[input]" value="for-noun-form">
	<input type="hidden" name="for-noun-form[mode]" value="edit-only">
    @if(isset($data['skimming'][0]['date_time']))Date Updated: {{  date('Y-m-d H:i', strtotime($data['for-noun-form'][0]['date_time'])) }} @endif
    <p>
        <label for="">Two things that happened in the book</label>
            <div class="row">
            <div class="col-xs-6">
                <textarea name="for-noun-form[data][happen-first]" rows="5" class="form-control input-lg" style="resize: none" placeholder="Write Here"> @if(isset($data['for-noun-form'][0]['happen-first'])) {{ $data['for-noun-form'][0]['happen-first'] }} @endif</textarea>
            </div>
            <div class="col-xs-6">
                <textarea name="for-noun-form[data][happen-end]" rows="5" class="form-control input-lg" style="resize: none" placeholder="Write Here">  @if(isset($data['for-noun-form'][0]['happen-end'])) {{ $data['for-noun-form'][0]['happen-end'] }} @endif</textarea>
            </div>
        </div>
    </p>
    <br>
    <p>
        <label for="">Three NOUNS in the book</label>
        <div class="row">
            <div class="col-xs-4">
                <input type="text" name="for-noun-form[data][first_noun]"  @if(isset($data['for-noun-form'][0]['first_noun'])) value="{{ $data['for-noun-form'][0]['first_noun']}}" @endif  class="form-control input-lg" placeholder="Write Here">
            </div>
            <div class="col-xs-4">
                <input type="text" name="for-noun-form[data][second_noun]" @if(isset($data['for-noun-form'][0]['second_noun'])) value="{{ $data['for-noun-form'][0]['second_noun']}}" @endif  class="form-control input-lg" placeholder="Write Here">
            </div>
            <div class="col-xs-4">
                <input type="text" name="for-noun-form[data][third_noun]" @if(isset($data['for-noun-form'][0]['third_noun'])) value="{{ $data['for-noun-form'][0]['third_noun']}}" @endif  class="form-control input-lg" placeholder="Write Here">
            </div>
        </div>
    </p>
    <br>

    <p>
        <label for="">Write your favorite things from the book</label>
        <textarea name="for-noun-form[data][favorite-things-from-the-book]" rows="8"  style="resize: none" class="form-control input-lg"  placeholder="Write Here"> @if(isset($data['for-noun-form'][0]['favorite-things-from-the-book'])) {{ $data['for-noun-form'][0]['favorite-things-from-the-book']}} @endif</textarea>
    </p>
        {{-- <br>
        <br>
        <br>
        <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button> --}}
</div>


