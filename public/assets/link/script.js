$(document).ready(function () {
    $('#cep').mask('00000-000');
    $('#cep').focusout(function () {
        var cep = $('#cep').val();
        cep = cep.replace("-", "");

        var urlStr = "https://viacep.com.br/ws/" + cep + "/json/";

        $.ajax({
            url: urlStr,
            type: 'get',
            dataType: 'json',

            success: function (data) {
                console.log(data);
                $('#logradouro').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#localidade').val(data.localidade);
            },
            error: function () {
                alert("Ocorreu um erro buscar o endereço do cliente.");
            }
        });
    });

    $('table tr td  #btnDelete').on('click', function () {
        var id = $(this).attr("id_link");
        let url = $(this).data('url');
        // alert('ID ' + id + " Minha URL " + url );
        $.ajaxSetup({
            headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: 'GET',
            url: url,
            data: { 'id': id },
            success: function (data) {

                $("#id_excluir").val(data.id);

                $('#confirmaExclucao').modal('show');
            },
            error: function () {
                alert("Ocorreu um erro ao carregar o link .");
            }
        });
    });

    var table = $('#tblLink').DataTable({
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
                extend: 'excel',
                text: '<i class="fa fa-files-o"></i> Excel',
                titleAttr: 'Excel',
                className: 'btn btn-primary btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                className: 'btn btn-primary btn-sm',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                pageSize: 'A4',
                filename: 'PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                }, customize: function (doc) {
                    var now = new Date();
                    var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                    var total_equipamentos = table.rows({ selected: true }).count();
                    doc.defaultStyle.fontSize = 7;
                    // Lagurar da tabela ao gerar PDF.
                    doc.content[1].table.widths = ['4%', '10%', '8%', '10%', '22%', '10%', '8%', '12%', '6%', '6%', '18%'];

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

        ]
    });
});