$(function () {
    var enviando_form = false;

    resetarFormUsuario = function () {
        console.log('limpando form');
        $('form input[name="operacao"]').val('insere');
        $('form button[type="submit"]').html('Inserir');
        $('#form-usuarios').parent().children(':first-child').children().html('Add novo usuário...');
        $('#form-usuarios input[name="id"]').remove();
    };
    $('form button[type="reset"]').click( resetarFormUsuario );

    function adicionaUsuarioNaTabela(dados) {
        /*
         * BUG: quando o usuário cadastra um novo usuário e este é adicionado na tabela
         * corrigir os botões com os quais eles são listados e associar os eventos aos botões
         */

        var novaLinhaTabela = $('<tr id="' + dados.id + '">');
        var cols = '';
        cols += '<td>';
        cols += '   <div class="btn-group">';
        cols += '       <button type="button" class="btn btn-default"><i class="fa fa-remove"></i></button>';
        cols += '       <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i></button>';
        cols += '   </div>';
        cols += '</td>';
        cols += '<td>' + dados.id + '</td>';
        cols += '<td>' + dados.nome + '</td>';
        cols += '<td>';
        cols += '   <span class="label ' + (dados.status === 'ativo' ? 'label-success' : 'label-danger') + '">';
        cols += '   ' + dados.status;
        cols += '   </span>';
        cols += '</td>';

        novaLinhaTabela.append(cols);
        $('table.table').append(novaLinhaTabela);
        
        //associa os eventos aos novos botões
        $('tr#'+dados.id).children('td:first-child').children('div').children('button').children('i.fa-remove').parent().bind('click', desativarUsuario);
        $('tr#'+dados.id).children('td:first-child').children('div').children('button').children('i.fa-remove').parent().bind('click', btnEditarUsuClick);
    }
    ;

    atualizaDadosNaTabela = function (dados_usu) {
        //console.debug(dados_usu);
        // captura a linha no usuário
        linha = $('tr#' + dados_usu.id);
        linha.children('td:nth-child(3)').html(dados_usu.nome);
    };

    btnEditarUsuClick = function () {
        //precisa obter info completa sobre o usu para mostrar no form
        var btnEditar = $(this);
        var tableRow = btnEditar.parent().parent().parent();
        var id = parseInt(tableRow.children('td:nth-child(2)').html());

        $.ajax({
            url: "/hermes/ajax/ajax_usuarios.php",
            type: 'POST',
            data: {operacao: 'infocompleta', id: id},
            dataType: 'json',
            cache: false,
            success: function (data) {
                //console.log('ajax bem sucedido!');
                //console.debug(data);

                if (data.status === 'ok') {
                    //console.log('status = ok');
                    $('#form-usuarios input[name="operacao"]').val('alterar');
                    $('#form-usuarios input[name="nome"]').val(data.usuario.nome);
                    $('#form-usuarios input[name="login"]').val(data.usuario.login);
                    $('#form-usuarios input[name="senha"]').val('');
                    $('#form-usuarios input[name="confirma_senha"]').val('');

                    if (data.usuario.permissoes.envia_sms) {
                        $('#form-usuarios input[name="envia_sms"]').prop('checked', true);
                    } else {
                        $('#form-usuarios input[name="envia_sms"]').prop('checked', false);
                    }

                    if (data.usuario.permissoes.ver_logs) {
                        $('#form-usuarios input[name="ver_logs"]').prop("checked", true);
                    } else {
                        $('#form-usuarios input[name="ver_logs"]').prop("checked", false);
                    }

                    if (data.usuario.permissoes.controle_usuarios) {
                        $('#form-usuarios input[name="controle_usuarios"]').prop("checked", true);
                    } else {
                        $('#form-usuarios input[name="controle_usuarios"]').prop("checked", false);
                    }

                    $('#form-usuarios button[type="submit"]').html('Atualizar');
                    $('#form-usuarios').parent().children(':first-child').children().html('Atualizar dados do usuário...');

                    $('#form-usuarios').append($('<input type="hidden" name="id" value="' + id + '">'));
                }
            }
        });
    };
    $('table tbody button .fa-pencil').parent().click(btnEditarUsuClick);
    /*************************************************************************\
     |                                                                         |
     |                            DESATIVAR USUÁRIO                            |
     |                                                                         |
     \*************************************************************************/
    desativarUsuario = function () {
        var btnRmv = $(this);
        var tableRow = btnRmv.parent().parent().parent();

        //obtem a segunda <td> (que contem o código do usuário), e extrai o id
        var id = parseInt(tableRow.children('td:nth-child(2)').html());
        //faz o ajax
        $.ajax({
            url: "/hermes/ajax/ajax_usuarios.php",
            type: "POST",
            data: {operacao: 'desativar', id: id},
            dataType: 'text',
            cache: false,
            success: function (data) {
                console.log(data);
                //muda a label de ativo para inativo
                tableRow.children('td:last-child').children('span').removeClass('label-success');
                tableRow.children('td:last-child').children('span').addClass('label-danger');
                tableRow.children('td:last-child').children('span').html('inativo');

                //muda o botão para um botão de ativar
                btnRmv.children('i').removeClass('fa-remove');
                btnRmv.children('i').addClass('fa-check');
                //muda o evento de click do botão
                btnRmv.unbind('click', desativarUsuario);
                btnRmv.bind('click', ativarUsuario);

                console.log(data.mensagem);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('erro na requisição');
                alert('Opa... Houve um erro na comunicação com o servidor! :(');
            }
        });
    };

    $('table tbody button .fa-remove').parent().click(desativarUsuario);

    /*************************************************************************\
     |                                                                         |
     |                            ATIVAR USUÁRIO                               |
     |                                                                         |
     \*************************************************************************/
    ativarUsuario = function () {
        //botão que foi clicado
        var btnAtivar = $(this);
        //linha do botão que foi clicado
        var tableRow = btnAtivar.parent().parent().parent();
        //pega o id da linha
        var id = parseInt(tableRow.children('td:nth-child(2)').html());
        //ajax
        $.ajax({
            url: "/hermes/ajax/ajax_usuarios.php",
            type: 'POST',
            data: {operacao: 'ativar', id: id},
            dataType: 'json',
            cache: false,
            success: function (data) {
                //console.log(data);
                //muda a label para ativo
                tableRow.children('td:last-child').children('span').removeClass('label-danger');
                tableRow.children('td:last-child').children('span').addClass('label-success');
                tableRow.children('td:last-child').children('span').html('ativo');

                //muda o estilo botão para um botão de desativar
                btnAtivar.children('i').removeClass('fa-check');
                btnAtivar.children('i').addClass('fa-remove');

                //muda o evento do botão
                btnAtivar.unbind('click', ativarUsuario);
                btnAtivar.bind('click', desativarUsuario);

                //console.log(data.mensagem);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    };
    $('table tbody button .fa-check').parent().click(ativarUsuario);

    $('#form-usuarios').submit(function () {
        // o objeto do formulário
        var obj = this;
        var form = $(obj);
        //o botão de submit
        var submit_btn = $('#form-usuarios :submit');

        //armazena o texto padrão do botão de Submit
        var submit_btn_default_txt = submit_btn.val();
        //dados do formulário
        var dados = new FormData(obj);
        //var dados = form.serialize();

        function volta_submit() {
            submit_btn.removeAttr('disabled');
            submit_btn.val(submit_btn_default_txt);
        }

        //se não está enviando o form
        if (!enviando_form) {
            //envia dados com ajax
            $.ajax({
                beforeSend: function () {
                    enviando_form = true;
                    submit_btn.attr('disabled', true);
                    submit_btn.val('Enviando...');
                },
                url: form.attr('action'),
                type: form.attr('method'),
                data: dados,
                dataType: 'json',
                processData: false,
                cache: false,
                contentType: false,
                success: function (data) {
                    //console.debug(data);
                    
                    if ($('form input[name="operacao"]').val() === 'insere') {
                        adicionaUsuarioNaTabela(data.usuario);
                    } else if ($('form input[name="operacao"]').val() === 'alterar') {
                        atualizaDadosNaTabela(data.usuario);
                    }

                    volta_submit();
                    resetarFormUsuario();
                    enviando_form = false;
                    form[0].reset();
                    alert(data.mensagem);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Algo deu errado! Atualize a página e tente novamente!");
                }
            });
        }

        //anula o envio convencional do form
        return false;
    });
});