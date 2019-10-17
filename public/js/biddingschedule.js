//Fill queues for officer and array for shift
$("#send-btn").click(function (){

    //Fill the officer queue array before sending the the controller.
    $( ".officer-queue-array" ).each(function( index ) {

        var valueInput = $( this ).val();
        var indexVal = index + 1;

        $('#value_' + indexVal).val($('#value_' + indexVal).val() + valueInput);
    });

    //Fill the shift array before sending to the controller.
    $( ".shift-queue-array" ).each(function( index ) {

        var valueInput = $( this ).val();
        //alert(valueInput);
        //console.log(valueInput);

        if(this.checked) {
            $('#shift_hidden_' + index).val($('#shift_hidden_' + index).val() + valueInput);
        }
    });

});

//Date can not be less than current date.
$(document).ready(function () {
    $("#start_date").datepicker({ minDate: 0 });
});



