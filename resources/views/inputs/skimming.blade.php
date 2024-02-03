<div  class="inputs-container">
    <input type="hidden" name="skimming[input]" value="skimming">
	<input type="hidden" name="skimming[mode]" value="edit-only">
    @if(isset($data['skimming'][0]['date_time']))Date Updated: {{  date('Y-m-d H:i', strtotime($data['skimming'][0]['date_time'])) }} @endif
    <br>
    <div class="row">
        <div class="col-xs-4">
            <img src="/images/placeholders/about-story.png" class="img-responsive" alt="">
        </div>
        <div class="col-xs-8">
            <p>
                <label for="">Setting ( Place / Time ) 배경 (장소/시간)</label>
                <input type="text" name="skimming[data][setting]" class="form-control input-lg"  @if(isset($data['skimming'][0]['setting'])) value="{{ $data['skimming'][0]['setting']}}" @endif >
            </p>
            <br>
            <p>
                <label for="">Main Character / Characters (주인공/등장인물)</label>
                <input type="text" name="skimming[data][main-character]" class="form-control input-lg"  @if(isset($data['skimming'][0]['main-character'])) value="{{ $data['skimming'][0]['main-character']}}" @endif >
            </p>
        </div>
    </div>
    <br>
    <p>
        {{-- <label for="">Development of the Story <span class="text-muted">How many events can you see in the story?</span></label> --}}
        <label for="">Development of the Story (이야기의 전개) <span class="text-muted">Write those important happenings of the story in order! <br> 이야기 속의 중요한 사건들을  차례로 정리해서 써보세요!</span></label>
        <textarea name="skimming[data][development-of-the-story]" cols="30" rows="10" class="form-control input-lg" style="resize:none">   @if(isset($data['skimming'][0]['development-of-the-story'])) {{ $data['skimming'][0]['development-of-the-story'] }} @endif </textarea>
    </p>
    <br>
    <p>
        {{-- <label for="">What is the ‘Major Event’ of the story? </label> --}}
        <label for="">Main idea of the Story (이야기의 중심 생각) </label>
        <span class="text-muted">Summarize the whole story you can effectively deliver the main idea!</span> <br>
        <span class="text-muted">이야기의 중심 생각이 효과적으로 전달 될 수 있도록 전체 이야기의 줄거리를 정리하여 써보세요</span>
        <textarea name="skimming[data][major-event]" cols="30" rows="10" class="form-control input-lg"  style="resize:none">   @if(isset($data['skimming'][0]['major-event'])) {{ $data['skimming'][0]['major-event'] }} @endif </textarea>
    </p>
    {{-- <div class="text-right">
        <br>
        <br>
        <br>
        <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button>
    </div> --}}
</div>
