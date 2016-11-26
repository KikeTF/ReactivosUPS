jQuery(function($) {
    $("#btn-comentarios").on(ace.click_event, function() {
        bootbox.prompt("Ingrese si sus comentarios...", function(result) {
            if (result === null) {
                console.log("null");
            } else {
                console.log("not null");
            }
        });
    });
});

