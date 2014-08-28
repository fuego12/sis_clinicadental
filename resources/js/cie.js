$(document).ready(function() {

    $(".tooltip-cie").tooltip();
    $("#table-cie").DataTable();
    
    var codi_edit_enf = "";
    
    $(".editar_cie").click(function() {

        var tr = $(this).parent().parent();
        
        codi_edit_enf = tr.find("td").eq(0).html();
        
        $("#codi_cie_e").val(tr.find("td").eq(0).html());
        $("#titu_cie_e").val(tr.find("td").eq(1).html());
        $("#desc_cie_e").val(tr.find("td").eq(2).html());

        $("#ModalEditarEnfermedad").modal("show");
    });

    $('#form_enf').submit(function() {

        var codi_enf = $("#codi_cie").val();

        var sw_registrar = false;
        $("#enfermedades-rep li").each(function() {
            if ($(this).html() == codi_enf) {
                sw_registrar = true;
                var dialogo = confirm("Ya existe una enfermedad del código ingresado, ¿Desea editar la enfermedad?");
                if (dialogo == true) {
                    $("#enfermedades-det tr").each(function() {
                        if ($(this).find("td").eq(0).html() == codi_enf) {
                            var tr = $(this);
                            $("#codi_cie_e").val(tr.find("td").eq(0).html());
                            $("#titu_cie_e").val(tr.find("td").eq(1).html());
                            $("#desc_cie_e").val(tr.find("td").eq(2).html());
                            
                            $("#ModalNuevaEnfermedad").modal("hide");
                            $("#ModalEditarEnfermedad").modal("show");
                        }
                    });                    
                }
            }
        });
        if (sw_registrar) {
            return false;
        }
    });

    $('#form_enf_edit').submit(function() {

        var codi_enf = $("#codi_cie_e").val();

        var sw_editar = false;
        $("#enfermedades-rep li").each(function() {
            if (codi_edit_enf != $(this).html() && $(this).html() == codi_enf) {
                sw_editar = true;
                var dialogo = confirm("Ya existe una enfermedad del código ingresado, ¿Desea editar la enfermedad?");
                if (dialogo == true) {
                    var tr = $("#table-cie tbody tr td:contains('" + codi_enf + "')").parent();

                    $("#codi_cie_e").val(tr.find("td").eq(0).html());
                    $("#titu_cie_e").val(tr.find("td").eq(1).html());
                    $("#desc_cie_e").val(tr.find("td").eq(2).html());
                    
                    codi_edit_enf = codi_enf;
                }
            }
        });
        if (sw_editar) {
            return false;
        }
    });

});