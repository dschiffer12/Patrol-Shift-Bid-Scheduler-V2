$('#shiftTable').on('clicked.rs.row',function (evt){

        $(this).toggleClass('active');

    // Now it's safe to check what was selected
    var rows = $(this).selectedrows();
    console.log(rows);
});

/*$(document).ready(function() {
    console.log('Holla Consol');
    var table = $('#shiftTable').DataTable();

    $('#shiftTable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    $('#button').click( function () {
        alert( table.rows('.selected').data().length +' row(s) selected' );
    } );
} );*/

