<div class="inputs-container">
    <input type="hidden" name="drawing[input]" value="drawing">
	<input type="hidden" name="drawing[mode]" value="edit-only">
    <label></label>
    <textarea style="display:none" name="drawing[data][generatedimage]" id="generatedImage">@if(isset($data['drawing'][0]['generatedimage'])){{ $data['drawing'][0]['generatedimage']}}@endif</textarea>
    {{-- <input type="text" name="drawing[data][generatedimage]" @if(isset($data['drawing'][0]['generatedimage'])) value="{{ $data['drawing'][0]['generatedimage']}}" @endif id="generatedImage"> --}}


    @if(Request::get('component') == 4)
        <label for="">Draw the picture of the cover of the book! </label> <br>
        <span class="text-muted">(커버 제목과 그림을 보고 자신이 상상한 내용을 그림으로 표현해보세요!)</span>
    @elseif(Request::get('component') == 5)
        <label for="">Draw What happens at the Beginning of the Story! </label> <br>
        <span class="text-muted">(이야기의 시작에 무슨 일이 있었나요? 내용을 그림으로 표현해보세요!)</span>
    @elseif(Request::get('component') == 6)
        <label for="">Draw What happens at the Middle of the Story! </label> <br>
        <span class="text-muted">(이야기의 중간에 무슨 일이 있었나요? 내용을 그림으로 표현해보세요!)</span>
    @elseif(Request::get('component') == 7)
         <label for="">Draw What happens at the End of the Story! </label> <br>
        <span class="text-muted">(이야기의 끝에 무슨 일이 있었나요? 내용을 그림으로 표현해보세요!)</span>
    @endif
  
    @if(isset($data['drawing'][0]['generatedimage']))
        <br>
        Date Updated: {{  date('Y-m-d H:i', strtotime($data['drawing'][0]['date_time'])) }}
        <img  src="{{ $data['drawing'][0]['generatedimage'] }}" alt="" @auth class="visible-print" @else class="img img-responsive" @endif>
    @endif
    @auth
        @if(!isset($hideInput))
            <div id="drawing-editor" class="hidden-print">
                <canvas id="mycanvas"></canvas>
            </div>
        @endif
    @endauth

    <br>
</div>

@auth
@push('styles')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tui-image-editor/3.13.0/tui-image-editor.css" integrity="sha512-fbhvP5+QvTyYA6W4G6gcbjdQOiSjVnmbnyAb9OfrI9oD7uLRh77waYwziFU31cMzcPblhYuBmFUOoV81ltK/6w==" crossorigin="anonymous" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tui-image-editor/3.10.0/tui-image-editor.css" integrity="sha512-xU5gZM8rCk0Znw6R4XwRTzca6KU3+abnnoQ5ueQ+UA4Oz2AP5S93kOqpSwbCgvzmmveagBrvaV1RLAz/I+5Muw==" crossorigin="anonymous" />
@endpush

@push('scripts')
    <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
{{--    <script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/tui-image-editor/3.13.0/tui-image-editor.min.js" integrity="sha512-hdxqrAENqbFIE39r3+HOwOjDCwsS/NPkx4Nvdd6xNQwoSuCwIIlifkEZi/OEqpInMXaj10cuiOUbREr1Lv0gdA==" crossorigin="anonymous"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tui-image-editor/3.10.0/tui-image-editor.min.js" integrity="sha512-7SokGJpWMUeu5xsDa092uYk8u3C7Z3UkYzMyYMinpsDAtjW+txQxXCVzgctVT5oeMT9il7xNA7wqLtyaWrB8mA==" crossorigin="anonymous"></script>
    <script src='/js/asset/white-theme.js'></script>
    <script>
            var imageEditor = new tui.ImageEditor('#drawing-editor', {
                    includeUI: {
                        // menu: ['shape', 'crop'],
                        loadImage: {
                            path: @if(isset($data['drawing'][0]['generatedimage'])) '{{$data['drawing'][0]['generatedimage']}}' @else '/images/bg/blank-white.JPG' @endif,
                            name: 'People'
                        },
                        theme: whiteTheme, // or whiteTheme
                        initMenu: 'draw',
                        menuBarPosition: 'right',
                        uiSize: {'width':'100%', 'height':'660px'}
                    },
                    cssMaxWidth: document.documentElement.clientWidth,
                    cssMaxHeight: document.documentElement.clientHeight,
                    selectionStyle: {
                        cornerSize: 10,
                        rotatingPointOffset: 70
                    },
                    save: function(e){

                    }
                });

            window.onresize = function() {
                imageEditor.ui.resizeEditor();
            }

            imageEditor.on('mousedown', function(event, originPointer) {
                $('#saving-icon').show()
                setTimeout(function(){
                    var canvas = $("canvas");

                    var img    = canvas[0].toDataURL("image/png");
                    $('#generatedImage').val(img)
                    $('#saving-icon').hide()
                }, 800)
            });
    </script>
@endpush
@endauth
