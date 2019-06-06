$(document).ready(function () {


    function clearFilds() {
        $('#empresa').val('');
        $('#documento').val('');
        $('#descricao').val('');
    }

    $('#btnInsert').on('click', function () {
        clearFilds();
        $('#modalInsertDocumento').modal('show');

    });

    $('table tr td #btnExcluirDocumento').on('click', function () {

        var id = $(this).attr("id_doc");
        let url = $(this).data('url');
     
        $.ajaxSetup({
            headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: 'GET',
            url: url,
            data: {'id':id},
            success: function (data) {
                // Carregando as Informações do documento dentro modal   
                $("#idDeleteDocumento").val(data.id);
                $("#nomeDocumento").val(data.nome);

                $('#confirmaExclucao').modal('show');
            },
            error: function () {
                alert("Ocorreu um erro carregar o equipamento.");
            }
        });
    });

    /***
     * @description
     * Carregando o documento para editar
     * @param id
     * @returns documento
     */
    $('table tr td #btnEditarDocumento').on('click', function () {

        var id = $(this).attr("id_doc");
        let url = $(this).data('url');

        $.ajaxSetup({
            headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: 'GET',
            url: url,
            data: { 'id': id },
            success: function (data) {
                // Carregando as Informações do documento dentro modal de edição   
                $("#idEdit").val(data.id);
                $("#empresaEdit").val(data.empresa);
                $("#descricaoEdit").val(data.descricao);
                
                $('#modalUpdateDocumento').modal('show');
            },
            error: function () {
                alert("Ocorreu um erro carregar o equipamento.");
            }
        });
    });
});