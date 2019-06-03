$(document).ready(function () {
    /**
    * @description:
    * Essa constante tem a URL principal
    * do projeto e deve ser usada como pre-fixo em
    * carregamentode de arquivos.
    * @returns json
    */
    const LINK = "http://localhost/equipment/public/";

    /**
    * @description:
    * Essa variavel tem o adicionamento
    * do plugin DataTable na tabela, Como também a configuração
    * do relatório de equipamentos emprestados
    */
    var table = $('#tblEquipamento').DataTable({
        "bPaginate": false,
        processing: true,
        serverSide: true,
        ajax: LINK + "equipamento",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'local', name: 'local' },
            { data: 'setor', name: 'setor' },
            { data: 'usuario', name: 'usuario' },
            { data: 'equipamento', name: 'equipamento' },
            { data: 'descricao', name: 'descricao' },
            { data: 'serial', name: 'serial' },
            { data: 'tombo', name: 'tombo' },
            { data: 'fornecedor', name: 'fornecedor' },
            { data: 'marca', name: 'marca' },
            { data: 'computador', name: 'computador' },
            { data: 'observacoes', name: 'observacoes' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Nada Encontrado",
            "info": "Mostrando páginas _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum equipamento encontrado",
            "infoFiltered": "(Filtrado de _MAX_ registros no total)",
            "paginate": {
                "previous": "Anterior",
                "next": "Próximo"
            },
            "search": "Pesquisar"
        },

        buttons: [
            {
                text: 'Relatório em pdf',
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: '  ',
                extend: 'pdf',
                footer: true,
                pageSize: 'A4', //A3 , A5 , A6 , legal 
                filename: 'relatório',
                exportOptions: {
                    columns: [1, 2, 4, 5, 6, 7, 8, 9, 11]
                },
                customize: function (doc) {
                    var now = new Date();
                    var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                    var total_equipamentos = table.rows({ selected: true }).count();
                    doc.defaultStyle.fontSize = 7;
                    // Lagurar da tabela ao gerar PDF.
                    doc.content[1].table.widths = ['8%', '8%', '8%', '10%', '9%', '6%', '10%', '6%', '40%'];
                 
                    // Cabeçalho do relatório em pdf
                    doc['header'] = (function () {
                        return {
                            columns: [
                                {
                                    text: 'Relatório de Equipamentos - NTI',
                                    fontSize: 14,
                                    alignment: 'left',
                                    margin: [10, 0]
                                },
                                {
                                    alignment: 'right',
                                    fontSize: 14,
                                    text: 'Secrétaria da Reparação',
                                }
                            ],
                            margin: 23
                        }
                    });
                    // Create a footer object with 2 columns
                    // Left side: report creation date
                    // Right side: current page and total pages
                    doc['footer'] = (function (page, pages) {
                        return {
                            columns: [
                                {
                                    alignment: 'left',
                                    text: ['Criado em: ', { text: jsDate.toString() }]
                                },
                                {
                                    alignment: 'center',
                                    text: ['Total de Equipamentos: ', { text: total_equipamentos }]
                                },
                                {
                                    alignment: 'right',
                                    text: ['Pagina ', { text: page.toString() }, ' de ', { text: pages.toString() }]
                                }
                            ],
                            margin: 20
                        }
                    });
                }
            },
            {
                extend: 'copyHtml5',
                text: 'Cópia Relatório',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
        ]
    });

    function clearFields() {
        $('#txtCadLocal').val('');
        $('#txtCadSetor').val('');
        $('#txtCadUsuario').val('');
        $('#softHard').val('');
        $('#txtCadDescricao').val('');
        $('#txtCadSerial').val('');
        $('#txtCadTombo').val('');
        $('#txtCadFornecedor').val('');
        $('#txtCadMarca').val('');
        $('#computador').val('');
        $('#txtCadObs').val('');
    }

    function clearFieldsEmprestimo() {
        $('#destino').val('');
        $('#telefone').val('');
        $('#data_saida').val('');
        $('#data_devolucao').val('');
        $('#nome').val('');
        $('#descricao').val('');
    }

    $('#btnInsert').on('click', function () {
        clearFields();
        $('#btnSalvar').show();
        $('#btnUpdate').hide();
        $('#modalInsertUpdate').modal('show');
    });
    /**
     * @description
     * Fazendo requisição ajax para alterar o equipamento
     * @return: Equipamento json
     */
    $('#btnUpdate').on('click', function (e) {
        // Requisição ajax para alterar equipamento.
        e.preventDefault();
        let url = $(this).data('url');
        var form = $('#insertEquipamento');
        var formData = form.serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (data) {
                if ((data.errors)) {
                    var danger = $('#danger');
                    danger.hide().find('ul').empty();
                    $.each(data.errors, function (index, error) {
                        danger.find('ul').append('<li>' + error + '</li>');
                    });
                    danger.slideDown();
                } else {
                    Swal.fire(
                        'Alterado com sucesso!',
                        'Click no botão OK para fechar!',
                        'success',
                    );
                    table.ajax.reload();
                    $('#modalInsertUpdate').modal('hide');
                    clearFields();
                }
            },
            error: function () {
                alert("Ocorreu um erro ao alterar o equipamento.");
            }
        });


    });
    /** 
     * @description
     * Salvar equipamentos no banco atraveis de uma requição ajax
     * @returns json
     */
    $("#btnSalvar").click(function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        var form = $('#insertEquipamento');
        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (data) {
                if ((data.errors)) {
                    var danger = $('#danger');
                    danger.hide().find('ul').empty();
                    $.each(data.errors, function (index, error) {
                        danger.find('ul').append('<li>' + error + '</li>');
                    });
                    danger.slideDown();
                } else {
                    Swal.fire(
                        'Equipamento salvo sucesso!',
                        'Click no botão OK para fechar!',
                        'success'
                    );
                    $('#modalInsertUpdate').modal('hide');
                    clearFields();
                    table.ajax.reload();
                }
            },
            error: function () {
                Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'Ocorreu um error ao salvar o equipamento!',
                    footer: '<a href>Why do I have this issue?</a>'
                });
            }
        });

    });
    /** 
     * @description
     * Excluir equipamentos via ajax 
     * @returns json 
     */
    $('#btnConfirmarExclusao').on('click', function () {
        let url = $(this).data('url');

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('input[name=idExcluir]').val()
            },
            success: function (data) {
                // TO-DE Fazer: teste de validação para não exlcuir equipamento emprestados;
                Swal.fire(
                    'Equipamento excluido sucesso!',
                    'Click no botão OK para fechar!',
                    'success'
                );
                $('#confirmaExclucao').modal('hide');
                table.ajax.reload();
            },
            error: function () {
                alert("Ocorreu um erro ao excluir o equipamento.");
            }
        });
    });
    /*Quando fechar o modal deve ocultar  as messagens de errors*/
    $('#modalInsertUpdate').on('hide.bs.modal', function (event) {
        $('#danger').hide();
    });
    /*Quando fechar o modal de emprestimo deve ocultar  as messagens de errors*/
    $('#modalEmprestimo').on('hide.bs.modal', function (event) {
        $('#dangerEmprestimo').hide();
    });

    /** 
     @description
     Salvando emprestimo no banco de dados
     @returns json
    */
    $('#btnConfirmaEmprestimo').on('click', function (e) {
        e.preventDefault();
        let url = $(this).data('url');

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                '_token': $('input[name=_token]').val(),
                'equipamento_id': $('input[name=equipamento_id]').val(),
                'destino': $("input[name='destino']").val(),
                'telefone': $("input[name='telefone']").val(),
                'data_saida': $("input[name='data_saida']").val(),
                'data_devolucao': $("input[name='data_devolucao']").val(),
                'nome': $("input[name='nome']").val(),
                'descricao': $("textarea[name='descricao']").val()
            },
            success: function (data) {

                if ((data.errors)) {
                    var dangerEmprestimo = $('#dangerEmprestimo');
                    dangerEmprestimo.hide().find('ul').empty();
                    $.each(data.errors, function (index, error) {
                        dangerEmprestimo.find('ul').append('<li>' + error + '</li>');
                    });
                    dangerEmprestimo.slideDown();
                } else {
                    window.open(LINK + 'home/saida', '_blank');
                    $('#modalEmprestimo').modal('hide');
                    clearFieldsEmprestimo();
                    // alert('Emprestimo feito com sucesso!');
                    Swal.fire(
                        'Emprestimo feito com sucesso!',
                        'Click no botão OK para fechar!',
                        'success'
                    );

                }
            },
            error: function () {
                alert("Ocorreu um erro ao empresta.");
            }
        });

    });
    $('#btnAbrirOCS').on('click', function () {
        window.open(' http://192.168.187.6/ocsreports/', '_blank');
    });
    $('#btnAbrirOcomon').on('click', function () {
        window.open('http://www.ocomon.salvador.ba.gov.br/', '_blank');
    });
});



