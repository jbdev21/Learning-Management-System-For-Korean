<div  class="inputs-container">
    @forelse($data[$componentid]['for-noun-form'] as $nounForm)
        <p>
            <label for="">Two things that happened in the book</label>
                <div class="row">
                <div class="col-xs-6">
                    <textarea rows="5" class="form-control" placeholder="Write Here"> @if(isset($nounForm['happen-first'])) {{ $nounForm['happen-first']}} @endif</textarea>
                </div>
                <div class="col-xs-6">
                    <textarea rows="5" class="form-control" placeholder="Write Here">  @if(isset($nounForm['happen-end'])) {{ $nounForm['happen-end']}} @endif</textarea>
                </div>
            </div>
        </p>
        <br>
        <p>
            <label for="">Three NOUNS in the book</label>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text"  @if(isset($nounForm['first_noun'])) value="{{ $nounForm['first_noun']}}" @endif  class="form-control input-lg" placeholder="Write Here">
                </div>
                <div class="col-xs-4">
                    <input type="text"  @if(isset($nounForm['second_noun'])) value="{{ $nounForm['second_noun']}}" @endif  class="form-control input-lg" placeholder="Write Here">
                </div>
                <div class="col-xs-4">
                    <input type="text"  @if(isset($nounForm['third_noun'])) value="{{ $nounForm['third_noun']}}" @endif  class="form-control input-lg" placeholder="Write Here">
                </div>
            </div>
        </p>
        <br>

        <p>
            <label for="">Write your favorite things from the book</label>
            <textarea name="for-noun-form[data][favorite-things-from-the-book]" rows="8" class="form-control" placeholder="Write Here"> @if(isset($nounForm['favorite-things-from-the-book'])) {{ $nounForm['favorite-things-from-the-book']}} @endif</textarea>
        </p>
    @endforeach
</div>


