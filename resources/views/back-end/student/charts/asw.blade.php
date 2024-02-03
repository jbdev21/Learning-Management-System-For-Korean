@extends('back-end.includes.layouts.main')
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
        <div class="table-responsive scrolly_table chart-table chart-height" id="scrolling_table_1">
            <table class="table table-bordered text-center table-condensed" id="chart" style="font-size:12px;">
                <tr class="text-bold" style="background-color:#fff;">
                    <td colspan="5" class="text-left fixed freeze freeze_vertical" style="background-color:#fff">
                        <h3>LESSON TABLE / A.S.W <br>
                            {{ $student->username }}({{ $student->name }})</h3>
                    </td>
                    <td colspan="13" class="text-left fixed freeze freeze_vertical" style="background-color:#fff">
                        <ul>
                            <li>Teacher's Name ; Teacher in charge shall make her(his) name as she(he) gives a lesson for a
                                newly selected book.</li>
                            <li>Strategy for Lesson ; Intensive Reading - Teacher shall mark the date as the student
                                achieves the relevant learning. (e.g. Spread Thinking : 5/11)</li>
                        </ul>
                    </td>
                </tr>
                <tr class="text-bold text-md bg-ligblue">
                    <td class="fixed freeze">No</td>
                    <td class="fixed freeze">Title</td>
                    <td class="fixed freeze">AR</td>
                    <td class="fixed freeze">Teacher's Name</td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / I.S.E.</b>
                        <div>
                            Introduction
                        </div>
                        에세이 ; 서론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / I.S.E.</b>
                        <div>Body</div>
                        에세이 ; 서론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / I.S.E.</b>
                        <div>Conclusion</div>
                        에세이 ; 결론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / I.S.E.</b>
                        <div>Overall Draft</div>
                        에세이 ; 전체초안
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / S.R.E.</b>
                        <div>Introduction</div>
                        에세이 ; 서론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / S.R.E.</b>
                        <div>Body</div>
                        에세이 ; 서론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b> Essay / S.R.E.</b>
                        <div>Conclusion</div>
                        에세이 ; 결론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / S.R.E.</b>
                        <div>Overall Draft</div>
                        에세이 ; 전체초안
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / C.B.E.</b>
                        <div>Introduction</div>
                        에세이 ; 서론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / C.B.E.</b>
                        <div>Body</div>
                        에세이 ; 서론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / C.B.E.</b>
                        <div>Conclusion</div>
                        에세이 ; 결론
                    </td>
                    <td class="fixed freeze_vertical">
                        <b>Essay / C.B.E.</b>
                        <div> Overall Draft</div>
                        에세이 ; 전체초안
                    </td>
                    <td class="fixed freeze_vertical">
                        Teacher's
                        Note
                    </td>
                </tr>
                @foreach ($books as $book)
                    <tr>
                        <td class="bg-ligblue fixed freeze_horizontal">{{ $loop->iteration }}</td>
                        <td class="bg-ligblue fixed freeze_horizontal">
                            <div style="width:200px; text-align:left">{{ $book->title }}</div>
                        </td>
                        <td class="bg-ligblue fixed freeze_horizontal">{{ $book->ar_level }}</td>
                        <td class="bg-ligblue fixed freeze_horizontal">
                            @foreach ($student->classrooms as $room)
                                {{ $room->name }} @if (!$loop->last)
                                    /
                                @endif
                            @endforeach
                        </td>

                        {{-- Skills for Writing Ⅱ; Informative Summary Essay --}}
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 42) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [44, 45, 46, 47, 48, 49, 50]) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 51) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 63) }}</td>

                        {{-- Skills for Writing Ⅱ; Reaction Essay --}}
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 18) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [20, 22, 23, 24, 25, 26]) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 27) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 64) }}</td>

                        {{-- Skills for Writing Ⅱ;  Based Essay --}}
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 53) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [55, 56, 57, 58, 59, 60, 61]) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 62) }}</td>
                        <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 65) }}</td>

                        <td class="with-input text-left">
                            <div class="date-data">{{ $student->cellData($book->id, 'teacher-asw-comment') }}</div>
                            <input
                                style="display: none; border:1px solid red; padding:3px; width:100%; border-radius: 0px !important;"
                                type="search" data-cell="teacher-comment" class="input-date-data form-control"
                                data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $student->cellData($book->id, 'teacher-comment') }}">
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <script src="/js/asw.js"></script>
@endpush
@push('styles')
    <style>
        .position-fixed {
            position: fixed;
        }

        .bg-ligblue {
            background-color: rgb(191, 227, 248);
        }

        .zoomout {
            zoom: 0.3;
        }

        td {
            vertical-align: middle !important;
        }

        .text-sm {
            font-size: 10px;
        }

        .text-md {
            font-size: 12px;
        }

        .width-md div {
            width: 100px !important;
        }

        .with-input {
            padding: 0px;
        }

        .with-input input {
            border: none;
            width: 100px;
        }

        /* .chart-table{
                           height: 80vh;
                    } */
        .chart-height {
            height: 80vh;
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
