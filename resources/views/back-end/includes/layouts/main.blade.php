@include('back-end.includes.sections.header')

@include('back-end.includes.menus.navbar')
@include('back-end.includes.menus.side')

  <div class="content-wrapper">

    <section class="content-header">
      @yield('content-header')
    </section>

    <section class="content">
      @include('back-end.includes.alerts.errors')
      @include('back-end.includes.alerts.message')
      @include('back-end.includes.alerts.success')
      @include('back-end.includes.alerts.warning')
      @yield('content')
    </section>

  </div>
@include('back-end.includes.sections.footer')