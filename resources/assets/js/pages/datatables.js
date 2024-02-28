$(document).ready(function () {

    "use strict";

    $('#datatable1').DataTable({
        "language": {
            "sZeroRecords": "Nenhum resultado encontrado",
            "paginate": {
                "next": ">",
                "previous": "<"
            },
            "info": "Mostrando _START_ até _END_ de _TOTAL_",
            "sInfoEmpty": "Mostrando 0 até 0 de 0",
            "infoFiltered": "(Filtrando de _MAX_)",
            "decimal": ",",
            "thousands": ".",
            "lengthMenu": "Mostrando _MENU_",
            "search": "Buscar:"
        },
        "order": [[0, "desc"]]
    });

    $('#datatable3').DataTable({
        "scrollX": true
    });

    $('#datatable4 tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );

    // DataTable
    var table = $('#datatable4').DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },

    });
});
