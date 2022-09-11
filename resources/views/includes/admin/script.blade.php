{{-- Font Awesome 5 --}}
<script script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous">
</script>
{{-- Font Awesome 5 --}}

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
{{-- Bootstrap --}}

<script src="{{ url('backend/js/scripts.js') }}"></script>

{{-- MultipleSelect --}}
<script src="{{ url('backend/assets/multipleselect/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ url('backend/assets/multipleselect/js/bootstrap.bundle.js') }}"></script>
<script src="{{ url('backend/assets/multipleselect/js/bootstrap-select.js') }}"></script>
{{-- MultipleSelect --}}
{{-- Datatables --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="{{ url('backend/js/datatables-simple-demo.js') }}"></script> --}}
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $('#tableHistoryJabatan').DataTable();
        $('#tableHistoryTrainingInternal').DataTable();
        $('#tableHistoryTrainingEksternal').DataTable();
        $('#tableHistoryKeluarga').DataTable();
    });
</script>
{{-- Datatables --}}
{{-- OnkeyUp --}}
<script src="{{ url('backend/js/onkeyup_angka_huruf.js') }}"></script>
{{-- OnkeyUp --}}
