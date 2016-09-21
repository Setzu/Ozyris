/**
 * Created by david on 16/09/16.
 */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
        '<td>Full name:</td>'+
        '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
        '<td>Extension number:</td>'+
        '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
        '<td>Extra info:</td>'+
        '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
        '</table>';
}

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var _searchByType = parseInt( $('#search-by-types').val(), 10 );
        var office = string( data[2] ) || 0; // use data for the age column

        return true;
    }
);

$(document).ready(function() {
    var table = $('#example').DataTable( {
        "ajax": "../../data/ajax/data.txt",
        "columns": [
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "salary" }
        ],
        "language": {
            "search": "Recherche par mots clés",
            "paginate": {
                "previous": "Précédent",
                "next": "Suivant"
            }
        },
        "order": [[1, 'asc']]
    });

    $('#search-by-types').keyup( function() {
        table.draw();
    } );

    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'tr', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );