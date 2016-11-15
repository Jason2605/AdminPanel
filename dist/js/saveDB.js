function newAlert (type, message) {
    $("#alert-area").append($("<div class='alert " + type + " fade in' data-alert><p> " + message + " </p></div>"));
    $(".alert").delay(2000).fadeOut("slow", function () { $(this).remove(); });
}


function dbSave(value, uid, column){

    newAlert('alert-success', 'Value Updated!');

    $.post('Backend/updatePlayers.php',{column:column, editval:value, uid:uid},
    function(){
        //alert("Sent values.");
    });
}
