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
                        <h3>LESSON TABLE / READ  <br>
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
                @foreach ($books as $book)
                    <tr>
                        <td class="bg-ligblue fixed freeze_horizontal">{{ $loop->iteration }}</td>
                        <td class="bg-ligblue fixed freeze_horizontal">
                            <div style="width:200px; text-align:left">{{ $book->title }}</div>
                        </td>
                        <td class="bg-ligblue fixed freeze_horizontal">{{ $book->ar_level }}</td>
                        <td class="bg-ligblue fixed freeze_horizontal">
                            {{ $book->class_rooms }}
                        </td>

                        <td>{{ $book->improving_prediction }}</td>
                        <td class="with-input">
                            <div class="date-data">{{ $book->first_data_cell }}</div>
                            <input style="display: none" data-cell="Word(본문)" class="input-date-data" type="date"
                                data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $book->first_data_cell }}">
                        </td>
                        <td class="with-input">
                            <div class="date-data">{{ $book->second_data_cell }}</div>
                            <input style="display: none" data-cell="sound" class="input-date-data" type="date"
                                data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $book->second_data_cell }}">
                        </td>
                        <td class="with-input">
                            <div class="date-data">{{ $book->third_data_cell }}</div>
                            <input style="display: none" data-cell="Text(본문) Dictation/Puzzle" class="input-date-data"
                                type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $book->third_data_cell }}">
                        </td>
                        <td>{{ $book->after_reading_basic }}</td>
                        <td>{{ $book->after_reading_beginning }}</td>
                        <td>{{ $book->after_reading_middle }}</td>
                        <td>{{ $book->after_reading_end }}</td>
                        <td>{{ $book->after_reading_skimming }}</td>
                        <td>{{ $book->after_reading_organizer }}</td>

                        <td class="with-input">
                            <div class="date-data">{{ $book->fourth_data_cell }}</div>
                            <input style="display: none" data-cell="(Word Test; Text)" class="input-date-data"
                                type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $book->fourth_data_cell }}">
                        </td>
                        <td class="with-input">
                            <div class="date-data">{{ $book->fifth_data_cell }}</div>
                            <input style="display: none" data-cell="(Word Test; Plus)" class="input-date-data"
                                type="date" data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $book->fifth_data_cell }}">
                        </td>

                        {{-- Skills for Writing Ⅰ; Informative Summary Essay --}}
                        {{-- <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 42) }}</td>
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, [43, 44, 45, 46, 47, 48, 49, 50]) }}</td>   --}}
                        {{-- <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 51) }}</td>
                                                <td>{{ $book->studentLastUpdateDatePerComponent($student->id, 63) }}</td> --}}


                        <td class="with-input text-left">
                            <div class="date-data">{{ $book->sixth_data_cell }}</div>
                            <input
                                style="display: none; border:1px solid red; padding:3px; width:100%; border-radius: 0px !important;"
                                type="search" data-cell="teacher-comment" class="input-date-data form-control"
                                data-book="{{ $book->id }}" data-user="{{ $student->id }}"
                                value="{{ $book->sixth_data_cell }}">
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <script src="/js/erp.js"></script>
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
