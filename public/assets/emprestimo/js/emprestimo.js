$(document).ready(function () {
    /**
     * @description: 
     * Essa constante tem a URL principal
     * do projeto e deve ser usada como pre-fixo em 
     * carregamentode de arquivos.
     * @returns json
     */
    // const LINK = "http://localhost/equipment/public/";
    const LINK = "http://192.168.187.9/equipment/public/";
    /**
     * @description:
     * Função para excluir um  equipamento emprestado do DB
     * @param {*} id
     * @returns json 
     */
    function confimarDevolucao(id) {
        $.ajax({
            type: 'POST',
            url: LINK + 'devolver',
            async: false,
            data: { 'id': id },
            success: function (data) {
                $('#modalEmprestimo').modal('hide');
                table.ajax.reload();
                Swal.fire(
                    'Equipamento devolvido sucesso!',
                    'Click no botão OK para fechar!',
                    'success'
                );
            },
            error: function () {
                alert("Ocorreu um erro ao devolver  o equipamento.");
            }
        });
    }
    /**
     * @description: 
     * Essa variavel tem o adicionamento
     * do plugin DataTable na tabela, Como também a configuração
     * do relatório de equipamentos emprestados 
     */
    var table = $('#tblEmprestimo').DataTable({
        "bPaginate": false,
        processing: true,
        serverSide: true,
        ajax: LINK + "emprestimoAll",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'serial', name: 'serial' },
            { data: 'setor', name: 'setor' },
            { data: 'equipamento', name: 'equipamento' },
            { data: 'destino', name: 'destino' },
            { data: 'nome', name: 'nome' },
            { data: 'data_saida', name: 'data_saida' },
            { data: 'data_devolucao', name: 'data_devolucao' },
            { data: 'tombo', name: 'tombo' },
            { data: 'telefone', name: 'telefone' },
            { data: 'descricao', name: 'descricao' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [
            {
                "targets": 6,
                "data": "data_saida",
                "type": 'date-br',
                "format": 'dd/mm/yyy',
                "render": function (data) {
                    var date  = new Date(data);
                    var month = date.getMonth() + 1;
                    return date.getDate() + 1 + "/" + (month.length > 1 ? month : "0" + month) + "/" + date.getFullYear();

                }
            }, {
                "targets": 7,
                "data": "data_devolucao",
                "render": function (data) {
                    var date = new Date(data);
                    var month = date.getMonth() + 1;
                    return date.getDate() + 1 + "/" + (month.length > 1 ? month : "0" + month) + "/" + date.getFullYear();
                }
            }
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
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                className: 'btn btn-primary btn-sm',
                orientation: 'landscape',
                title: '  ',
                pageSize: 'A4',
                extend: 'pdf',
                filename: 'relatório de emprestimo',
                footer: true,
                exportOptions: {
                    columns: [2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
                customize: function (doc) {
                    var now = new Date();
                    var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                    var total_equipamentos = table.rows({ selected: true }).count();
                    doc.defaultStyle.fontSize = 7;
                    // Lagurar da tabela ao gerar PDF.
                    doc.content[1].table.widths = ['8%', '11%', '10%', '10%', '10%', '10%', '10%', '8%', '25%'];
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
                },
            },

            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                className: 'btn btn-primary btn-sm',
                text: 'Cópia Relatório',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
        ]
    });
    /**
     * @param {*} e
     * @description:
     *  Atualizar o emprestimo no DB
     *  Atraveis de uma requisição
     * @returns json 
     */
    $('#btnAtualizar').on('click', function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        var form = $('#CadEmprestimo');
        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (data) {
                if ((data.errors)) {
                    var dangerEmprestimo = $('#dangerEmprestimo');
                    dangerEmprestimo.hide().find('ul').empty();
                    $.each(data.errors, function (index, error) {
                        dangerEmprestimo.find('ul').append('<li>' + error + '</li>');
                    });
                    dangerEmprestimo.slideDown();
                } else {
                    Swal.fire(
                        'Equipamento Alterado sucesso!',
                        'Click no botão OK para fechar!',
                        'success'
                    );
                    $('#modalEmprestimo').modal('hide');
                    table.ajax.reload();
                }
            },
            error: function () {
                alert("Ocorreu um erro ao alterar o emprestimo.");
            }
        });
    });
    /**
     * @description 
     * Quando fechar o modal de emprestimo deve ocultar  as messagens de errors
     * */
    $('#modalEmprestimo').on('hide.bs.modal', function (event) {
        $('#dangerEmprestimo').hide();
    });

    /** 
     * @description 
     * Realizar a devolução do equipamento emprestados
     * @param {*} id
     * @returns json
     * */
    $('#btnConfirmarDevolver').on('click', function () {
        $('#confirmaDevolucao').modal('hide');

        var id = $('#id_equipamento').val();
        window.open(LINK + 'emprestimo/recibo/devolucao/' + id, '_blank');
        window.setTimeout(function () {
            confimarDevolucao(id);
        }, 5000);
    });
});