@extends("back-end.includes.layouts.main")  
@section('page-title', 'Students')
@section('content-header')
    <h1>
        Student Chart
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com/">Home</a></li>
        <li class="active">Student</li>
    </ol>
@endsection
@section('content')
        <button class="btn btn-warning hidden-print" id="print"><i class="fa fa-print"></i> Print</button>
        <button class="btn btn-warning hidden-print" id="export-cvs"><i class="fa fa-print"></i> Export Excel File</button>
        <br>
        <br>
        <div class="box">
                <div class="table-responsive scrolly_table chart-table" style="height: 500px" id="scrolling_table_1" >
                        <table class="table table-bordered text-center table-condensed" id="chart" style="font-size:12px;">
                                <tr class="text-bold fixed freeze" style="background-color:#fff; z-index:999;" >
                                        <td colspan="48" class="text-left"  style="background-color:#fff; z-index:999;"  ><h3>{{ $student->username}}({{ $student->name}})</h3></td>
                                </tr>
                                <tr class="text-bold text-md bg-ligblue">
                                        <td rowspan="4" class="fixed freeze">No</td>
                                        <td rowspan="4" class="fixed freeze">Title</td>
                                        <td rowspan="4" class="fixed freeze">AR</td>
                                        <td rowspan="4"  class="fixed freeze">Teacher's Name</td>
                                        <td colspan="22" class="text-md text-bold">Strategy for Lesson ; Intensive Reading</td>
                                        <td colspan="2" rowspan="2">Vocab. Master <br>(어휘)</td>
                                        <td rowspan="4">
                                        <div style="width:150px">Teacher Note</div>    </td>
                                </tr>
                                <tr class="text-bold text-md bg-ligblue fixed freeze_vertical">
                                        <td colspan="2">Skills for Thinking <br> (추론,단어)</td>
                                        <td colspan="2">During Reading <br> (유창성, 표현, 어법, 구문)</td>
                                        <td colspan="6">Skills for Thinking <br> (논리적 사고력, 쓰기 연습)</td>
                                        <td colspan="12">Essay Writing <br> (에세이 쓰기 연습)</td>   
                                </tr>
                                <tr class="text-md bg-ligblue fixed freeze_vertical">
                                                <td>Spread Thinking</td>
                                                <td>Word Preview</td>
                                                <td>O.R.P.L/C(R/C)</td>
                                                <td>Sentence Structure</td>
                                                <td>Spread Thinking (ⅰ)</td>
                                                <td colspan="3">Spread Thinking (ⅰi)</td>
                                                <td colspan="2">Build/Watch Thinking</td>
                                                <td colspan="4">Skills for Writing Ⅰ; Informative Summary Essay</td>
                                                <td colspan="4">Skills for Writing Ⅱ; Summary-Reaction Essay</td>
                                                <td colspan="4">Skills for Writing Ⅲ; Summary-Based Essay</td>
                                                <td>Word Test</td>
                                                <td>Voca Test(Extra)</td>
                                </tr>
                                <tr class="text-sm width-md bg-ligblue fixed freeze_vertical">
                                        <td><div>FW;Cover</div></td>
                                        <td><div>Word(본문)</div></td>
                                        <td><div>Sound</div></td>
                                        <td><div>Text(본문) Dictation/Puzzle</div></td>
                                        <td><div>FW;Basic(기초)</div></td>
                                        <td><div>FW;Improve-Beginning</div></td>
                                        <td><div>FW;Improve- Middle</div></td>
                                        <td><div>FW;Improve- End</div></td>
                                        <td><div>Skimming(Scanning)</div></td>
                                        <td><div>Graphic Organizer</div></td>
                                        <td><div>Introductory</div></td>
                                        <td><div>Body</div></td>
                                        <td><div>Concluding</div></td>
                                        <td><div>I.S.E. Overall Draft</div></td>
                                        <td><div>Introductory</div></td>
                                        <td><div>Body</div></td>
                                        <td><div>Concluding</div></td>
                                        <td><div>S.R.E. Overall Draft</div></td>
                                        <td><div>Introductory</div></td>
                                        <td><div>Body</div></td>
                                        <td><div>Concluding</div></td>
                                        <td><div>C.B.E. Overall Draft</div></td>
                                        <td><div>Word(본문)</div></td>
                                        <td><div>Word(Extra)</div></td>
                                </tr>
                                @foreach($books as $book)
                                        <tr>
                                                <td class="bg-ligblue fixed freeze_horizontal">{{ $loop->iteration }}</td>  
                                                <td class="bg-ligblue fixed freeze_horizontal"><div style="width:200px; text-align:left">{{ $book->title }}</div></td>  
                                                <td class="bg-ligblue fixed freeze_horizontal">{{ $book->ar_level }}</td>  
                                                <td class="bg-ligblue fixed freeze_horizontal"><div style="min-width:100px"></div></td>  

                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 4) }}</td>  
                                                <td class="with-input">
                                                        <div class="date-data">{{ $student->cellData($book->id, 'Word(본문)') }}</div>
                                                        <input style="display: none" data-cell="Word(본문)" class="input-date-data" type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}" value="{{ $student->cellData($book->id, 'Word(본문)') }}">
                                                </td>  
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'sound') }}</div>
                                                        <input style="display: none" data-cell="sound" class="input-date-data" type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}" value="{{ $student->cellData($book->id, 'sound') }}">
                                                </td>  
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'Text(본문) Dictation/Puzzle') }}</div>
                                                        <input style="display: none" data-cell="Text(본문) Dictation/Puzzle" class="input-date-data" type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}" value="{{ $student->cellData($book->id, 'Text(본문) Dictation/Puzzle') }}">
                                                </td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 8) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 5) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 6) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 7) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 11) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [30, 31, 32, 33, 34]) }}</td>

                                                {{-- Skills for Writing Ⅰ; Informative Summary Essay --}}
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 42) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [43, 44, 45, 46, 47, 48, 49, 50]) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 51) }}</td>
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 63) }}</td>

                                                {{-- Skills for Writing Ⅱ; Summary-Reaction Essay --}}
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 18) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [19, 20, 21, 22, 23, 24, 25, 26]) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 27) }}</td>
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 64) }}</td>

                                                {{-- Skills for Writing Ⅲ; Summary-Reaction Essay --}}
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 53) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [54, 55, 56, 57, 58, 59, 60, 61]) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 62) }}</td>
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 65) }}</td>

                                             
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'word-test') }}</div>
                                                        <input style="display: none" data-cell="word-test" class="input-date-data" type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}" value="{{ $student->cellData($book->id, 'word-test') }}">
                                                </td>  
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'Word(Extra)') }}</div>
                                                        <input style="display: none" data-cell="Word(Extra)" class="input-date-data" type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}" value="{{ $student->cellData($book->id, 'Word(Extra)') }}">
                                                </td>  
                                                <td class="with-input text-left"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'teacher-comment') }}</div>
                                                        <input  style="display: none; border:1px solid red; padding:3px; width:100%; border-radius: 0px !important;" type="search" data-cell="teacher-comment" class="input-date-data form-control"  data-book="{{ $book->id }}" data-user="{{ $student->id }}" value="{{ $student->cellData($book->id, 'teacher-comment') }}">
                                                </td>   
                                        </tr>
                                @endforeach
                        </table>
                </div>
        </div>
@endsection

@push('scripts')
        <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
        <script>
                $(document).ready(function(){
                        $('#print').click(function(){
                                $('body').addClass('zoomout')
                                window.print()
                                $('body').removeClass('zoomout')
                        })

                       var tableToExcel = (function () {
                                var uri = 'data:application/vnd.ms-excel;base64,',
                                        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                                        , base64 = function (s) {
                                        return window.btoa(unescape(encodeURIComponent(s)))
                                        }
                                        , format = function (s, c) {
                                        return s.replace(/{(\w+)}/g, function (m, p) {
                                                return c[p];
                                        })
                                        };
                                return function (table, name) {
                                        if (!table.nodeType) table = document.getElementById(table);
                                        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML};
                                        window.location.href = uri + base64(format(template, ctx));
                                }
                        })();


                        $("#export-cvs").click(function(e){
                                tableToExcel('chart','Document');
                        }); 

                        function freeze_pane_listener(what_is_this, table_class) {
  // Wrapping a function so that the listener can be defined
  // in a loop over a set of scrolling table id's.
  // Cf. http://stackoverflow.com/questions/750486/javascript-closure-inside-loops-simple-practical-example
  
        return function() {
                var i;
                var translate_y = "translate(0," + what_is_this.scrollTop + "px)";
                var translate_x = "translate(" + what_is_this.scrollLeft + "px,0px)";
                var translate_xy = "translate(" + what_is_this.scrollLeft + "px," + what_is_this.scrollTop + "px)";
                
                var fixed_vertical_elts = document.getElementsByClassName(table_class + " freeze_vertical");
                var fixed_horizontal_elts = document.getElementsByClassName(table_class + " freeze_horizontal");
                var fixed_both_elts = document.getElementsByClassName(table_class + " freeze");
                
                // The webkitTransforms are for a set of ancient smartphones/browsers,
                // one of which I have, so I code it for myself:
                for (i = 0; i < fixed_horizontal_elts.length; i++) {
                fixed_horizontal_elts[i].style.webkitTransform = translate_x;
                fixed_horizontal_elts[i].style.transform = translate_x;
                }

                for (i = 0; i < fixed_vertical_elts.length; i++) {
                fixed_vertical_elts[i].style.webkitTransform = translate_y;
                fixed_vertical_elts[i].style.transform = translate_y;
                }

                for (i = 0; i < fixed_both_elts.length; i++) {
                fixed_both_elts[i].style.webkitTransform = translate_xy;
                fixed_both_elts[i].style.transform = translate_xy;
                }
        }
        }

        function even_odd_color(i) {
                if (i % 2 == 0) {
                        return "#e0e0e0";
                } else {
                        return "#ffffff";
                }
        }

        function parent_id(wanted_node_name, elt) {
        // Function to work up the DOM until it reaches
        // an element of type wanted_node_name, and return
        // that element's id.
        
        var wanted_parent = parent_elt(wanted_node_name, elt);
        
        if ((wanted_parent == undefined) || (wanted_parent.nodeName == null)) {
        // Sad trombone noise.
                        return "";
                } else {
                        return wanted_parent.id;
                }
        }

        function parent_elt(wanted_node_name, elt) {
        // Function to work up the DOM until it reaches 
        // an element of type wanted_node_name, and return
        // that element.
        
        var this_parent = elt.parentElement;
        if ((this_parent == undefined) || (this_parent.nodeName == null)) {
        // Sad trombone noise.
                 return null;
        } else if (this_parent.nodeName == wanted_node_name) {
        // Found it:
                return this_parent;
        } else {
        // Recurse:
                return parent_elt(wanted_node_name, this_parent);
        }
        }

        var i, parent_div_id, parent_tr, table_i, scroll_div;
        var scrolling_table_div_ids = ["scrolling_table_1", "scrolling_table_2"];

        // This array will let us keep track of even/odd rows:
        var scrolling_table_tr_counters = [];
        for (i = 0; i < scrolling_table_div_ids.length; i++) {
        scrolling_table_tr_counters.push(0);
        }

        // Append the parent div id to the class of each frozen element:
        var fixed_elements = document.getElementsByClassName("fixed");
        for (i = 0; i < fixed_elements.length; i++) {
        fixed_elements[i].className += " " + parent_id("DIV", fixed_elements[i]);
        }

        // Set background colours of row headers, alternating according to 
        // even_odd_color(), which should have the same values as those
        // defined in the CSS for the tr_shaded class.
        var fixed_horizontal_elements = document.getElementsByClassName("freeze_horizontal");
        for (i = 0; i < fixed_horizontal_elements.length; i++) {
        parent_div_id = parent_id("DIV", fixed_horizontal_elements[i]);
        table_i = scrolling_table_div_ids.indexOf(parent_div_id);
        
        if (table_i >= 0) {
        parent_tr = parent_elt("TR", fixed_horizontal_elements[i]);
        
        if (parent_tr.className.match("tr_shaded")) {
        fixed_horizontal_elements[i].style.backgroundColor = even_odd_color(scrolling_table_tr_counters[table_i]);
        scrolling_table_tr_counters[table_i]++;
        }
        }
        }

        // Add event listeners.
        for (i = 0; i < scrolling_table_div_ids.length; i++) {
        scroll_div = document.getElementById(scrolling_table_div_ids[i]);
        scroll_div.addEventListener("scroll", freeze_pane_listener(scroll_div, scrolling_table_div_ids[i]));
        }
                })

             
        </script>
     
@endpush
@push('styles')
        <style>
                .position-fixed{
                        position: fixed;
                }

                .bg-ligblue{
                        background-color: rgb(191, 227, 248);
                }

                .zoomout{
                        zoom: 0.3;
                }
                td{
                        vertical-align: middle !important;
                }

                .text-sm{
                        font-size: 10px;
                }

                .text-md{
                        font-size: 12px;
                }

                .width-md div{
                        width:100px !important;
                }
                
                .with-input{
                        padding:0px;
                }
                .with-input input{
                        border: none;
                        width:100px;
                }

                 .chart-table{
                        min-height: 500px;
                }
                
               /* table {
                table-layout: fixed;
                } */

                /* td, th {
                padding-left: 5px;
                padding-right: 5px;
                } */

                .tr_shaded:nth-child(even) {
                        background: #e0e0e0;
                }

                .tr_shaded:nth-child(odd) {
                        background: #ffffff;
                }

                .scrolly_table {
                        white-space: nowrap;
                        overflow: auto;
                }

                /* The frozen cells will each get two class names,
                making it easier for me to select all of them or
                only a subset.  All frozen cells will be "fixed",
                the corner will also be in class "freeze", and the
                row and column headers will be "horizontal" and
                "vertical" respectively. */
                .fixed.freeze {
                        z-index: 10;
                        position: relative;
                        background-color: rgb(191, 227, 248);
                }

                .fixed.freeze_vertical {
                        z-index: 5;
                        position: relative;
                        background-color: rgb(191, 227, 248);
                }

                .fixed.freeze_horizontal {
                        z-index: 1;
                        position: relative;
                        background-color: rgb(191, 227, 248);
                }
        </style>
@endpush