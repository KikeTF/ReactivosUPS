function activa_op_resp(ind) {
    $("#activa_op_resp_"+ind).attr("hidden", true);
    $("#desactiva_op_resp_"+ind).attr("hidden", false);
    $("#id_opcion_correcta_"+ind).attr("disabled", false);
    $("#desc_op_resp_"+ind).attr("disabled", false);
    $("#arg_op_resp_"+ind).attr("disabled", false);
}

function desactiva_op_resp(ind) {
    $("#desactiva_op_resp_"+ind).attr("hidden", true);
    $("#activa_op_resp_"+ind).attr("hidden", false);
    $("#desc_op_resp_"+ind).val("");
    $("#arg_op_resp_"+ind).val("");
    $("#id_opcion_correcta_"+ind).attr("disabled", true);
    $("#desc_op_resp_"+ind).attr("disabled", true);
    $("#arg_op_resp_"+ind).attr("disabled", true);
}

function activa_op_preg(ind) {
    $("#activa_op_preg_"+ind).attr("hidden", true);
    $("#desactiva_op_preg_"+ind).attr("hidden", false);
    $("#conc_op_preg_"+ind).attr("disabled", false);
    $("#prop_op_preg_"+ind).attr("disabled", false);
}

function desactiva_op_preg(ind) {
    $("#desactiva_op_preg_"+ind).attr("hidden", true);
    $("#activa_op_preg_"+ind).attr("hidden", false);
    $("#conc_op_preg_"+ind).val("");
    $("#prop_op_preg_"+ind).val("");
    $("#conc_op_preg_"+ind).attr("disabled", true);
    $("#prop_op_preg_"+ind).attr("disabled", true);
}


