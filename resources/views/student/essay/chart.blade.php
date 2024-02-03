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

        <div class="table-responsive">
                <table class="table table-bordered text-center table-condensed" id="chart" style="font-size:12px;">
                        <tr class="text-bold">
                                <td colspan="48" class="text-left"><h3>{{ $student->username}}({{ $student->name}})</h3></td>
                        </tr>
                        <tr class="text-bold text-md bg-ligblue">
                                <td rowspan="4">No</td>
                                <td rowspan="4">Title</td>
                                <td rowspan="4">AR</td>
                                <td rowspan="4" >Teacher's Name</td>
                                <td colspan="22" class="text-md text-bold">Strategy for Lesson ; Intensive Reading</td>
                                <td colspan="2" rowspan="2">Vocab. Master <br>(어휘)</td>
                                <td rowspan="4">
                                        <div style="width:150px">Teacher Note</div>    </td>
                        </tr>
                        <tr class="text-bold text-md bg-ligblue">
                                <td colspan="2">Skills for Thinking <br> (추론,단어)</td>
                                <td colspan="2">During Reading <br> (유창성, 표현, 어법, 구문)</td>
                                <td colspan="6">Skills for Thinking <br> (논리적 사고력, 쓰기 연습)</td>
                                <td colspan="12">Essay Writing <br> (에세이 쓰기 연습)</td>   
                        </tr>
                        <tr class="text-md bg-ligblue">
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
                        <tr class="text-sm width-md bg-ligblue">
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
                                        <td class="bg-ligblue">{{ $loop->iteration }}</td>  
                                        <td class="bg-ligblue"><div style="width:200px; text-align:left">{{ $book->title }}</div></td>  
                                        <td class="bg-ligblue">{{ $book->ar_level }}</td>  
                                        <td class="bg-ligblue"><div style="min-width:100px"></div></td>  

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
                                                
                                        </td>  
                                        <td class="with-input"> 
                                                <div class="date-data">{{ $student->cellData($book->id, 'Word(Extra)') }}</div>
                                                
                                        </td>  
                                        <td class="with-input text-left"> 
                                                <div class="date-data">{{ $student->cellData($book->id, 'teacher-comment') }}</div>
                                                
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
                                tableToExcel('chart',"Chart-{{ $student->name }}" + new Date().toISOString().replace(/[\-\:\.]/g, ""));
                                // $('table').table2excel({
                                //         exclude: ".noExl",
                                //         name: "Excel Document Name",
                                //         filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                                //         fileext: ".xls",
                                //         exclude_img: true,
                                //         exclude_links: true,
                                //         exclude_inputs: true,
                                //         preserveColors: true
                                // });
                        }); 
                })

             
        </script>
     
@endpush
@push('styles')
        <style>

                .table-chart td{
                        vertical-align: center !important;
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
        </style>
@endpush