@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Student Essay Chart')

@section('content-header')
    <h1>
        Student Chart
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com/">Home</a></li>
        <li>Student</li>
        <li class="active">Essays Chart</li>
    </ol>
@endsection

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ $student->username }} ({{ $student->name }})</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive chart-table">
                  <table class="table table-bordered" style="font-size:12px;">
                        <tr>
                              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                              @foreach($components as $component)
                                    <td colspan="{{ $component->totalChildrenCount() }}" class="text-center">{{ $component->name }}</td>
                              @endforeach
                        </tr>      
                        <tr>
                              <td> </td>
                              @foreach($components as $component)
                                    @foreach($component->children as $children)
                                          <td colspan="{{ $children->children()->count() }}" class="text-center">{{ $children->name }}</td>
                                    @endforeach
                              @endforeach
                        </tr> 
                        <tr>
                              <td><b>Books</b></td>
                              @php 
                                    $totalComponent = 0;
                              @endphp
                              @foreach($components as $component)
                                    @foreach($component->children as $children)
                                          @foreach($children->children as $granchildren)
                                                @php 
                                                      $totalComponent++;
                                                @endphp
                                                {{-- <td>{{ $granchildren->name }}</td> --}}
                                                <td class="text-center fixed freeze_vertical">
                                                      <div style="width:80px" title="{{ $granchildren->name }}">
                                                            <i class="fa fa-sort"></i>
                                                            {{-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
                                                      </div>
                                                </td>
                                          @endforeach
                                    @endforeach
                              @endforeach
                        </tr>      
                        @forelse($books as $book)
                        <tr>
                              <td>{{ $book->title }}</td>
                              @foreach($components as $component)
                                    @foreach($component->children as $children)
                                          @foreach($children->children as $grandchildren)
                                                {{-- <td>{{ $granchildren->name }}</td> --}}
                                                <td class="text-center" style="width: 120px !important;">
                                                      @if($grandchildren->writings()->where('student', $student->id)->whereBookId($book->id)->count())
                                                            <a href="{{ route('back-end.writing.show', ['component' => $grandchildren->id  ,'book' => $book->id, 'student' => $student->id ]) }}">{{  $grandchildren->writings()->where('student', $student->id)->whereBookId($book->id)->orderBy('updated_at', 'DESC')->first()->updated_at->format('Y/m/d') }}</a>
                                                      @endif
                                                </td>
                                          @endforeach
                                    @endforeach
                              @endforeach
                        </tr>      
                        @empty
                              <tr>
                                    <td class="" colspan="{{ $totalComponent + 1 }}"> No Book with writing found </td>
                              </tr>
                        @endforelse
                  </table>  
            </div>  
          
        </div>
      </div>
@endsection
@push('styles')
<style>
      .chart-table{
            min-height: 500px;
      }
      
      .fixed.freeze {
            z-index: 10;
            position: relative;
      }

      .fixed.freeze_vertical {
            z-index: 5;
            position: relative;
      }

      .fixed.freeze_horizontal {
            z-index: 1;
            position: relative;
      }
</style>
@endpush