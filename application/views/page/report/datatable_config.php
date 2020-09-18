<script>
    $(document).ready(function() {
        $('#table').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'pdf',
            ],
            "lengthChange": true
        });
    });
</script>