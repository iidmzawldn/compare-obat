@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {

    @if(session('success'))
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Berhasil',
            body: "{{ session('success') }}",
            autohide: true,
            delay: 4000
        });
    @endif

    @if(session('error'))
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Error',
            body: "{{ session('error') }}",
            autohide: true,
            delay: 5000
        });
    @endif

    @if(session('warning'))
        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Warning',
            body: "{{ session('warning') }}",
            autohide: true,
            delay: 5000
        });
    @endif

    @if(session('info'))
        $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Info',
            body: "{{ session('info') }}",
            autohide: true,
            delay: 4000
        });
    @endif

});
</script>
@endsection
