let tables = {};

tables.setRow = function (
                id,
                name,
                localizacao,
                estado,
                justificacao,
                responsabilidade,
                edital_documento,
                coordenadas,
                data_encerramento,
                data_reabertura) {

    $("input[id='id']").val(id);
    $("input[id='name']").val(name);
    $("input[id='localizacao']").val(localizacao);
    $("input[id='estado']").val(estado);
    $("input[id='justificacao']").val(justificacao);
    $("input[id='responsabilidade']").val(responsabilidade);
    $("input[id='edital_documento']").val(edital_documento);
    $("input[id='coordenadas']").val(coordenadas);
    $("div[id='data_encerramento']").text("Valor anterior: " + data_encerramento);
    $("div[id='data_reabertura']").text("Valor anterior: " + data_reabertura);
};

tables.setRequired = function() {
    $('#permanente').change(function() {
        tables.isChecked();
    });
    $('#temporario').change(function() {
        tables.isChecked();
    });
};

tables.isChecked = function() {
    if ($('#permanente').is(':checked')) {
        $('#div-hora-encerramento').hide();
        $('#div-hora-reabertura').hide();
        $('#hora_encerramento').prop('required', false);
        $('#hora_reabertura').prop('required', false);
    }
    if ($('#temporario').is(':checked')) {
        $('#div-hora-encerramento').show();
        $('#div-hora-reabertura').show();
        $('#hora_encerramento').prop('required', true);
        $('#hora_reabertura').prop('required', true);
    }
};

$("document").ready(function() {
    tables.isChecked();
    tables.setRequired();
});