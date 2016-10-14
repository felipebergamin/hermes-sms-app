angular.module("hermes_app")
    .controller("sms_lote_ctrl", ['$scope', '$http', 'response_message_handler', controller]);


function controller($scope, $http, response_message_handler) {
    $scope.destinatarios = [];
    $scope.form = {
        loading: false,
        lote: {
            texto: ''
        }
    };

    /**
     * Reseta o form e suas variáveis no scopo
     */
    $scope.formReset = function () {
        document.getElementsByTagName('form')[0].reset();

        $scope.form = {
            lote: {
                texto: ""
            }
        };
    };

    /**
     * Manipula os checkboxes da tabela
     * @param bool True para marcar todos, false para desmarcar todos. Não informe nada para inverter as seleções.
     */
    $scope.toggleCheckboxes = function (bool) {
        if (typeof bool === 'boolean')
            angular.forEach($scope.destinatarios, function (val, key) {
                if (!val.block_envio)
                    val.enviar = bool;
            });
        else
            angular.forEach($scope.destinatarios, function (val, key) {
                if (!val.block_envio)
                    val.enviar = !val.enviar;
            });
    };

    /**
     * Limpa o form e os dados carregados do arquivo
     */
    $scope.cancelOperation = function () {
        $scope.formReset();
        $scope.destinatarios = [];
    };

    /**
     * Retorna str minimizada e sem barras e traços
     *
     * @param str
     * @returns string
     */
    $scope.minimizeString = function (str) {
        // substitui "non-word characters" por espaços em branco
        str = str.replace(/\W+/g, ' ');
        // remove espaços em branco
        str = str.replace(/\s+/g, '');
        // converte a string para letras minúsculas
        return str.toLowerCase();

        /*
         return str.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function(match, index) {
         if (+match === 0) return ""; // or if (/\s+/.test(match)) for white spaces
         return index == 0 ? match.toLowerCase() : match.toUpperCase();
         });
         */
    };

    /**
     * Recebe um número de telefone e retorna o mesmo sem parênteses e traços
     *
     * @param phone
     * @returns {*}
     */
    $scope.clearPhoneNumber = function (phone) {
        if (phone)
            return phone.replace(/\W+/g, '');

        return phone;
    };

    /**
     * Recebe um número e verifica se é um número de celular com o 9º dígito
     *
     * @param phone
     * @returns {*}
     */
    $scope.validateCellphoneNumber = function (phone) {

        if (phone) {
            var regex = new RegExp(/^169(8|9)\d+/g);

            return (regex.test(phone) && (phone.length === 11));
        }

        return phone;
    };

    /**
     * Recebe um número e verifica se é um número de celular sem o 9º dígito
     *
     * @param phone
     * @returns {*}
     */
    $scope.checkMissingNinthDigit = function (phone) {
        if (phone) {
            var regex = new RegExp(/16(8|9)\d+/g);

            return ((phone.length === 10) && regex.test(phone));
        }

        return phone;
    };

    /**
     * Recebe um número de celular e acrescenta o 9º dígito
     *
     * @param phone
     * @returns {*}
     */
    $scope.putNinthDigit = function (phone) {
        if (phone) {
            // concatena os dois primeiros dígitos (ddd) com um algarismo 9, e depois concatena com o restante do número
            return phone.substr(0, 2).concat('9').concat(phone.substr(2, phone.length - 1));
        }

        return phone;
    };

    var chooseNumber = function (telefones) {
        // faz um loop entre todos os celulares
        for (var i = 0; i < telefones.length; i++) {
            // se o celular é válido, retorna ele como selecionado
            if ($scope.validateCellphoneNumber(telefones[i])) {
                return telefones[i];
            }
            else { // se o celular não é válido
                // se falta apenas o 9º dígito no número para ele ser válido
                if ($scope.checkMissingNinthDigit(telefones[i])) {
                    // acrescenta o 9º dígito
                    var newtel = $scope.putNinthDigit(telefones[i]);

                    // verifica novamente se o celular é válido, se for, retorna o número
                    if ($scope.validateCellphoneNumber(newtel))
                        return newtel;
                }
            }
        }

        // caso nenhum número válido seja encontrado, retorna false
        return false;
    };

    var checkWhiteList = function (obj, callback) {
        val = $scope.clearPhoneNumber(obj.cpfcnpj);
        val += "|";
        val += $scope.clearPhoneNumber(obj.numero_destinatario);

        $http({
            method: "get",
            url: "/api/listabranca/consultar/" + val
        }).then(
            function (response) {
                callback(response.data === 'true');
            },
            function (response) {
                callback(null);
                response_message_handler.handle(response);
            }
        );
    };

    var markToSend = function (obj) {
        obj.enviar = true;
        obj.block_envio = false;
    };

    var markToDontSend = function (obj, msg_status) {
        obj.enviar = false;
        obj.block_envio = true;
        obj.msg_status = msg_status;
    };

    /**
     * Lê os registros do arquivo e os coloca na variável $scope.destinatarios
     */
    $scope.loadFile = function () {
        $scope.form.loading = true;

        var fs = new FileReader();

        // evento onload
        // disparado quando o FileReader termina de ler o arquivo
        fs.onload = function (e) {
            // limpa os registros atuais
            $scope.destinatarios = [];
            var html = $(e.target.result);

            // objeto que armazena qual coluna contem qual informação
            var indexHeader = [];

            // seleciona todos os <td> da primeira <tr>
            // esses <td> contém o cabeçalho da tabela
            $.each(html.find('tr:first>td'), function (i, el) {
                // percorre os <td> criando um índice de qual informação cada coluna possui
                var val = $scope.minimizeString(el.innerHTML);
                indexHeader[val] = i;
            });

            // remove o primeiro <tr> (cabeçalho) do DOM
            html.find('tr:first').remove();

            // só restaram <tr> com informações de clientes, então percorre todos esses <tr>
            $.each(html.find('tr'), function (i, el) {
                // para cada <td> dentro do <tr>
                var td = $(el).find("td");

                // pega as informações necessárias e cria um objeto
                var registro = {
                    'descricao_destinatario': td[indexHeader.nome].innerText,
                    'cpfcnpj': td[indexHeader.cpfcnpj].innerText,
                    'telefone': $scope.clearPhoneNumber(td[indexHeader.telefone].innerText),
                    'celular': $scope.clearPhoneNumber(td[indexHeader.celular].innerText),
                    'celular2': $scope.clearPhoneNumber(td[indexHeader.celular2].innerText),
                    'enviar': true,
                    'block_envio': false
                    /*
                     [enviar] e [block_envio] tem funções diferentes
                     enviar - opção do usuário enviar ou não o sms (é vinculado com o checkbox na view)
                     block_envio - o sistema encontrou ou não motivos para não enviar esse SMS,
                     pode ser por número de celular inválido, ou o destinatário se encontra
                     em lista branca, etc.
                     */
                };
                markToSend(registro);

                // chama a função que avalia os três números de telefone
                // e retorna o primeiro que for um número de celular
                registro.numero_destinatario = chooseNumber(
                    [registro.telefone, registro.celular, registro.celular2]
                );

                // se a função retornou false, quer dizer que nenhum dos três números é um celular válido
                if (registro.numero_destinatario === false) {
                    markToDontSend(registro, 'Nenhum número de celular válido encontrado!');
                }
                else { // se os números de telefone são corretos, então verifica se estão em lista branca
                    checkWhiteList(registro,
                        function (result) {
                            if (result === true)
                                markToDontSend(registro, "Encontrado na lista branca!");
                            else if (result === null)
                                markToDontSend(registro, "Não foi possível verificar a lista branca! Por precaução, não será enviado!");
                        })
                }

                // adiciona o objeto na coleção
                $scope.destinatarios.push(registro);
                // força o Angular a atualizar a view
                $scope.$apply();
            });

            toastr.success("O arquivo foi lido! " + $scope.destinatarios.length + " registros encontrados!");
            $scope.form.loading = false;
        };

        // executa a leitura assíncrona do arquivo
        fs.readAsText(document.getElementById('file').files[0], 'ISO-8859-15');
    };

    /**
     * Disparado quando o usuário confirma o envio do lote
     * Estrutura os dados e envia para o servidor
     */
    $scope.confirmOperation = function () {
        $http({
            method: 'post',
            url: '/api/smslote',
            data: {
                texto: $scope.form.lote.texto,
                descricao: $scope.form.lote.descricao,
                destinatarios: $scope.destinatarios
            }
        }).then(
            function s(response) {
                $scope.destinatarios = response.data;
            },
            response_message_handler.handle
        )
    };
}