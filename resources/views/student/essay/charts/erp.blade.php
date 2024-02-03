@extends("student.includes.layouts.empty")  
@section('page-title', 'Students')
@section('content-header')
    <h1>
        Student Chart
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">Student</li>
    </ol>
@endsection
@section('content')
<div style="margin-bottom:5px;">

        <button class="btn btn-warning hidden-print" id="print"><i class="fa fa-print"></i> Print</button>
        <button class="btn btn-warning hidden-print" id="export-cvs"><i class="fa fa-print"></i> Export Excel File</button>
</div>

        <div class="table-responsive scrolly_table chart-table chart-height" id="scrolling_table_1" >
                        <table class="table table-bordered text-center table-condensed" id="chart" style="font-size:12px;">
                                 <tr class="text-bold" style="background-color:#fff;" >
                                        <td colspan="5" class="text-left fixed freeze freeze_vertical"  style="background-color:#fff"  >
                                                <h3>LESSON TABLE / E.R.P <br>
                                                {{ $student->username}}({{ $student->name}})</h3>
                                        </td>
                                        <td colspan="13" class="text-left fixed freeze freeze_vertical"  style="background-color:#fff"  >
                                                <ul>
                                                        <li>Teacher's Name  ; Teacher in charge shall make her(his) name as she(he) gives a lesson for a newly selected book.</li>
                                                        <li>Strategy for Lesson ; Intensive Reading - Teacher shall mark the date as the student achieves the relevant learning. (e.g. Spread Thinking : 5/11)</li>
                                                </ul>
                                        </td>
                                </tr>
                                <tr class="text-bold text-md bg-ligblue">
                                        <td class="fixed freeze">No</td>
                                        <td class="fixed freeze">Title</td>
                                        <td class="fixed freeze">AR</td>
                                        <td class="fixed freeze">Teacher's Name</td>
                                        <td class="fixed freeze_vertical">
                                                <b>Before Reading</b>
                                                <div>
                                                        (FW ; Improving ; Prediction)
                                                </div>
                                                논리/사고 ; 내리쓰기 ; 추론
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>Before Reading</b>
                                                <div>(Word Preview)</div>
                                                사전 단어 학습
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>During Reading</b>
                                                <div>(Oral Reading Practice)</div>
                                                유창성 낭독 연습
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>During Reading</b>
                                                <div>(R. Grammar)</div>
                                                어법, 구문
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>After Reading</b>
                                                <div>(FW ; Basic)</div>
                                                논리/사고 ; 내리쓰기 ; 기초
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>After Reading</b>
                                                <div>(FW ; Improving ; Beginning)</div>
                                                논리/사고 ; 내리쓰기 ; 발전 ; 서론
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>After Reading</b>
                                                <div>(FW ; Improving ; Middle)</div>
                                                논리/사고 ; 내리쓰기 ; 발전 ; 본론
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>After Reading</b>
                                                <div>(FW ; Improving ; End)</div>
                                                논리/사고 ; 내리쓰기 ; 발전 ; 결론
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>After Reading</b>
                                                <div>(Skimming)</div>
                                                논리/사고 ; 통독; 글의 주제 이해
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>After Reading</b>
                                                <div>(Graphic Organizer)</div>
                                                논리/사고 ; 통독; 마인드맵
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>Voca. Master</b>
                                                <div>(Word Test; Text)</div>
                                                단어시험 ; 본문
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                <b>Voca. Master</b>
                                                <div> (Word Test; Plus)</div>
                                                단어시험 ; 보카 
                                        </td>
                                        <td class="fixed freeze_vertical">
                                                Teacher's
                                                Note
                                        </td>
                                </tr>
                                @foreach($books as $book)
                                        <tr>
                                                <td class="bg-ligblue fixed freeze_horizontal">{{ $loop->iteration }}</td>  
                                                <td class="bg-ligblue fixed freeze_horizontal"><div style="width:200px; text-align:left">{{ $book->title }}</div></td>  
                                                <td class="bg-ligblue fixed freeze_horizontal">{{ $book->ar_level }}</td>  
                                                <td class="bg-ligblue fixed freeze_horizontal">
                                                @foreach($student->classrooms as $room)
                                                        {{ $room->name }} @if(!$loop->last) / @endif
                                                @endforeach        
                                                </td>  

                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 4) }}</td>  
                                                <td class="with-input">
                                                        <div class="date-data">{{ $student->cellData($book->id, 'Word(본문)') }}</div>
                                                        </td>  
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'sound') }}</div>
                                                </td>  
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'Text(본문) Dictation/Puzzle') }}</div>
                                                </td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 8) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 5) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 6) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 7) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 11) }}</td>  
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [30, 31, 32, 33, 34]) }}</td>

                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, '(Word Test; Text)') }}</div>
                                                </td>  
                                                <td class="with-input"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, '(Word Test; Plus)') }}</div>
                                                </td>  

                                                <td class="text-left"> 
                                                        <div class="date-data">{{ $student->cellData($book->id, 'teacher-arp-comment') }}</div>
                                                </td>   
                                        </tr>
                                @endforeach
                        </table>
                </div>
   
@endsection

@push('scripts')
        <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
        <script>
                $(document).ready(function(){
                        $('#print').click(function(){
                                $('body').addClass('zoomout')
                                $('.chart-table').removeClass('chart-height')
                                $('.chart-table').removeClass('scrolly_table')
                                window.print()
                                $('body').removeClass('zoomout')
                                $('.chart-table').addClass('chart-height')
                                $('.chart-table').addClass('scrolly_table')
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

                 /* .chart-table{
                       height: 80vh;
                } */
                 .chart-height{
                       height: 100vh;
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