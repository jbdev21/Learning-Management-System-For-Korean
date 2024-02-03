<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
     
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ auth()->user()->avatar }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li><a href="{{ url('/') }}" class="header"> <i class="fa fa-home"></i> <span> HOME</a></li>
        {{-- <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li> --}}
        <li class="treeview {!! back_end_active_menu(['writing'], 2) !!}">
          <a href="#">
            <i class="fa fa-area-chart"></i> <span> Evaluation</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" {!! back_end_active_menu(['writing', 'show', 'diary', 'recording', 'quiz'], 2, 'style="display:block"') !!}>
            <li><a href="{{ route('back-end.writing.index') }}"><i class="fa fa-angle-right"></i> Writings</a></li>
            <li><a href="{{ route('back-end.diary.index') }}"><i class="fa fa-angle-right"></i> Diary Entry & Journal</a></li>
            <li><a href="{{ route('back-end.recording.index') }}"><i class="fa fa-angle-right"></i> Recording</a></li>
             <li><a href="{{ route('back-end.quiz.index') }}"><i class="fa fa-angle-right"></i> GW Grammar Exercise</a></li>
          </ul>
        </li>
        <li class="treeview {!! back_end_active_menu(['student', 'class-room'], 2) !!}">
          <a href="#">
            <i class="fa fa-user"></i> <span>Students</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" {!! back_end_active_menu(['student'], 2, 'style="display:block"') !!}>
            <li><a href="{{ route('back-end.student.create') }}"><i class="fa fa-angle-right"></i> Create New</a></li>
            <li><a href="{{ route('back-end.student.index') }}"><i class="fa fa-angle-right"></i> List</a></li>
          </ul>
        </li>
        @if(auth()->user()->type != "teacher")
          {{-- <li class="treeview {!! back_end_active_menu(['word-puzzle'], 2) !!}">
            <a href="#">
              <i class="fa fa-suitcase"></i> <span>Grammar Exercise</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['quiz','word-puzzle'], 2, 'style="display:block"') !!}>
              <li><a href="{{ route('back-end.grammar.index') }}"><i class="fa fa-angle-right"></i> Grammar</a></li>
              <li><a href="{{ route('back-end.word-puzzle.index') }}"><i class="fa fa-angle-right"></i> Word Puzzle</a></li>
            </ul>
          </li> --}}

          <li class="treeview {!! back_end_active_menu('book', 2) !!}">
            <a href="#">
              <i class="fa fa-book"></i> <span>Book</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['book', 'library'], 2, 'style="display:block"') !!}>
              <li><a href="{{ route('back-end.book.create') }}"><i class="fa fa-angle-right"></i> Create New</a></li>
              <li><a href="{{ route('back-end.book.index') }}"><i class="fa fa-angle-right"></i> List</a></li>
              <li><a href="{{ route('back-end.library.index') }}"><i class="fa fa-angle-right"></i> Library</a></li>
            </ul>
          </li>
          <li class="treeview {!! back_end_active_menu('audiobook', 2) !!}">
            <a href="#">
              <i class="fa fa-play-circle"></i> <span>Audio Book</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['audiobook'], 2, 'style="display:block"') !!}>
              <li><a href="{{ route('back-end.audiobook.create') }}"><i class="fa fa-angle-right"></i> Create New</a></li>
              <li><a href="{{ route('back-end.audiobook.index') }}"><i class="fa fa-angle-right"></i> List</a></li>
            </ul>
          </li>
          <li class="treeview {!! back_end_active_menu(['student-rank', 'essay-rank'], 2) !!}">
            <a href="#">
              <i class="fa fa-star"></i> <span>Ranks</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['student-rank', 'essay-rank'], 2, 'style="display:block"') !!}>
              <li><a href="{{ route('back-end.student-rank.index') }}"><i class="fa fa-angle-right"></i> Student</a></li>
{{--              <li><a href="#"><i class="fa fa-angle-right"></i> Essay <small class="text-danger">(not yet available)</small></a></li>--}}
            </ul>
          </li>

          <li class="treeview {!! back_end_active_menu(['class-room', 'subject'], 2) !!}">
            <a href="#">
              <i class="fa fa-folder-open"></i> <span>Manage</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['class-room', 'subject', 'teacher'], 2, 'style="display:block"') !!}>
               <li><a href="{{ route('back-end.teacher.index') }}"><i class="fa fa-angle-right"></i> Teachers</a></li>
               <li><a href="{{ route('back-end.class-room.index') }}"><i class="fa fa-angle-right"></i> Class Rooms</a></li>
              <li><a href="{{ route('back-end.subject.index') }}"><i class="fa fa-angle-right"></i> Subjects</a></li>
            </ul>
          </li>
          <li class="treeview {!! back_end_active_menu(['notice', 'banner', 'Class Posting'], 2) !!}">
            <a href="#">
              <i class="fa fa-sticky-note"></i> <span>Content</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['notice', 'banner', 'Class Posting'], 2, 'style="display:block"') !!}>
              <li><a href="{{ route('back-end.banner.index') }}"><i class="fa fa-angle-right"></i> Banner</a></li>
              <li><a href="{{ route('back-end.notice.index') }}"><i class="fa fa-angle-right"></i> Notice</a></li>
              <li><a href="{{ route('back-end.notice.index', ['type' => 'grammar']) }}"><i class="fa fa-angle-right"></i> Grammar</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Class Posting</a></li>
            </ul>
          </li>
          <li class="treeview {!! back_end_active_menu(['sub-admin', 'branch', 'component', 'setting', 'center', 'log'], 2) !!}">
            <a href="#">
              <i class="fa fa-gear"></i> <span>System</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" {!! back_end_active_menu(['sub-admin', 'branch', 'component', 'setting', 'center', 'log', 'grading'], 2, 'style="display:block"') !!}>
              <li><a href="{{ route('back-end.center.index') }}"><i class="fa fa-angle-right"></i> Center Profile</a></li>
              <li><a href="{{ route('back-end.sub-admin.index') }}"><i class="fa fa-angle-right"></i> Sub-admin</a></li>

              <li><a href="{{ route('back-end.component.index') }}"><i class="fa fa-angle-right"></i> Components</a></li>
              <li><a href="{{ route('back-end.branch.index') }}"><i class="fa fa-angle-right"></i> Branch</a></li>
              <li><a href="{{ route('back-end.grading.index') }}"><i class="fa fa-angle-right"></i> Grading</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Settings</a></li>
              <li><a href="#"><i class="fa fa-angle-right"></i> Logs</a></li>
            </ul>
          </li>
        @endif
      </ul>
      <div class="text-center mt-5 show-mobile">
        <a href="#" data-toggle="push-menu" class="btn btn-default" role="button">
          <i class="fa fa-arrow-left"></i> Close Menu
        </a>
      </div>
    </section>
    <!-- /.sidebar -->
  </aside>
