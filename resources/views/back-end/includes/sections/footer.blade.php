      
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
            <b>Version</b> {{ getVersion() }}
            </div>
            <strong>Copyright &copy; {{ date('Y') }}  All rights
            reserved.
        </footer>
</div>
<!-- Scripts -->
<script src="{{ asset('js/back-end.js') }}"></script>
<script>
$(document).ready(function () {
    $('.sidebar-menu').tree()
})
</script>
@stack('scripts')
    @show
</body>
</html>