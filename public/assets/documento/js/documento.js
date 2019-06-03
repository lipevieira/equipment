$(document).ready(function(){

    function clearFilds(){
        $('#documento').val('');
        $('#empresa').val('');
        $('#descricao').val('');
    }
    
    $('#btnInsert').on('click', function(){
        $('#btnSalvar').show();
        $('#btnUpdate').hide();
        $('#modalInsertDocumento').modal('show');
    });
});