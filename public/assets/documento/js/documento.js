$(document).ready(function () {

    function clearFilds() {
        $('#documento').val('');
        $('#empresa').val('');
        $('#descricao').val('');
    }

    $('#btnInsert').on('click', function () {
        $('#btnSalvar').show();
        $('#btnUpdate').hide();
        $('#modalInsertDocumento').modal('show');
    });

    $('#btnExcluirDocumento').on('click', function () {

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
                console.log(data.id);
                $('#confirmaExclucao').modal('show');
            },
            error: function () {
                alert("Ocorreu um erro carregar o equipamento.");
            }
        });
    });
});