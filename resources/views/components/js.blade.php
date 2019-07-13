<!-- Argon Scripts -->
<!-- Core -->
<script type="text/javascript" src="{{ asset('./assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.vi.min.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('./assets/plugins/sweetalert2.all.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: 'today',
        language: 'vi'
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('js')
<!-- Argon JS -->
<script src="{{ asset('./assets/js/argon.js?v=1.0.0') }}"></script>
<script src="{{ asset('/js/ltc.js') }}"></script>
@yield('departmentJs')