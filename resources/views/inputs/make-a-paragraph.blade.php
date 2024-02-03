<div  class="inputs-container">
      <input type="hidden" name="make-a-paragraph[input]" value="make-a-paragraph">
	<input type="hidden" name="make-a-paragraph[mode]" value="edit-only">
      @if(isset($data['make-a-paragraph'][0]['date_time']))
       Date: {{ date('Y-m-d H:i', strtotime($data['make-a-paragraph'][0]['date_time'])) }}
       @endif
       <br>
      <table class='table table-bordered'>
            <tr>
                  <td></td>
                  <td class="text-center">Topic Sentences</td>
                  <td class="text-center">Supporting Sentences (1)</td>
                  <td class="text-center">Supporting Sentences (2)</td>
                  <td class="text-center">Concluding Sentences</td>
            </tr>
            <tr>
                  <td>Paragraph #1</td>
                  <td><textarea name="make-a-paragraph[data][paragraph1_top_sentence]"  class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph1_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph1_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph1_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph1_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph1_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph1_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph1_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph1_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph1_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph1_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph1_concluding_sentences'] }} @endif</textarea></td>
            </tr>
            <tr>
                  <td>Paragraph #2</td>
                  <td><textarea name="make-a-paragraph[data][paragraph2_top_sentence]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph2_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph2_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph2_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph2_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph2_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph2_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph2_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph2_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph2_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph2_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph2_concluding_sentences'] }} @endif</textarea></td>
            </tr>
            <tr>
                  <td>Paragraph #3</td>
                  <td><textarea name="make-a-paragraph[data][paragraph3_top_sentence]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph3_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph3_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph3_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph3_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph3_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph3_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph3_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph3_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph3_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph3_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph3_concluding_sentences'] }} @endif</textarea></td>
            </tr>
            <tr>
                  <td>Paragraph #4</td>
                  <td><textarea name="make-a-paragraph[data][paragraph4_top_sentence]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph4_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph4_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph4_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph4_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph4_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph4_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph4_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph4_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph4_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph4_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph4_concluding_sentences'] }} @endif</textarea></td>
            </tr>
            <tr>
                  <td>Paragraph #5</td>
                  <td><textarea name="make-a-paragraph[data][paragraph5_top_sentence]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph5_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph5_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph5_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph5_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph5_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph5_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph5_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph5_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph5_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph5_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph5_concluding_sentences'] }} @endif</textarea></td>
            </tr>
            <tr>
                  <td>Paragraph #6</td>
                  <td><textarea name="make-a-paragraph[data][paragraph6_top_sentence]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph6_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph6_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph6_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph6_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph6_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph6_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph6_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph6_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph6_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph6_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph6_concluding_sentences'] }} @endif</textarea></td>
            </tr>
            <tr>
                  <td>Paragraph #7</td>
                  <td><textarea name="make-a-paragraph[data][paragraph7_top_sentence]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph7_top_sentence'])){{ $data['make-a-paragraph'][0]['paragraph7_top_sentence'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph7_sentence2]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph7_sentence2'])){{ $data['make-a-paragraph'][0]['paragraph7_sentence2'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph7_sentence3]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph7_sentence3'])){{ $data['make-a-paragraph'][0]['paragraph7_sentence3'] }} @endif</textarea></td>
                  <td><textarea name="make-a-paragraph[data][paragraph7_concluding_sentences]" class='form-control no-border-input' rows="8">@if(isset($data['make-a-paragraph'][0]['paragraph7_concluding_sentences'])){{ $data['make-a-paragraph'][0]['paragraph7_concluding_sentences'] }} @endif</textarea></td>
            </tr>
      </table>
       {{-- <div class="text-right">
        <br>
        <br>
        <br>
        <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button>
       </div> --}}
</div>

@push('styles')
      <style>
            .no-border-input{
                  border:none;
                  box-shadow: none;
            }
            .no-border-input:focus{
                  outline:0;
            }
      </style>
@endpush