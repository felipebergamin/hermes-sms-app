/**
 * Created by felipe on 02/09/16.
 */

angular.module("hermes_app", ['response_message_handler'])
    .controller("sms_lote_ctrl", function ($scope, $http, response_message_handler) {
        $scope.destinatarios = [];

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

        /**
         * Lê os registros do arquivo e os coloca na variável $scope.destinatarios
         */
        $scope.loadFile = function () {
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
                        'nome': td[indexHeader.nome].innerText,
                        'cpfcnpj': td[indexHeader.cpfcnpj].innerText,
                        'celular': $scope.clearPhoneNumber(td[indexHeader.celular].innerText),
                        'celular2': $scope.clearPhoneNumber(td[indexHeader.celular2.innerText]),
                        'enviar': true,
                        'block_envio': false
                    };

                    if (!$scope.validateCellphoneNumber(registro.celular)) {

                        if ($scope.checkMissingNinthDigit(registro.celular)) {
                            registro.celular = $scope.putNinthDigit(registro.celular);
                        }
                        else {
                            registro.enviar = false;
                            registro.block_envio = true;
                        }
                    }

                    // adiciona o objeto na coleção
                    $scope.destinatarios.push(registro);
                    // força o Angular a atualizar a view
                    $scope.$apply();
                });

                toastr.success("O arquivo foi lido! " + $scope.destinatarios.length + " registros encontrados!");
            };

            // executa a leitura do arquivo
            fs.readAsText(document.getElementById('file').files[0], 'ISO-8859-15');
        };

        /**
         * Disparado quando o usuário confirma o envio do lote
         * Estrutura os dados e envia para o servidor
         */
        $scope.confirmOperation = function () {
            var params = {
                texto: $scope.form.lote.texto,
                descricao: $scope.form.lote.descricao,
                destinatarios: []
            };

            angular.forEach($scope.destinatarios,
                function (val) {
                    if (val.enviar)
                        params.destinatarios.push(val);
                }
            );

            $http({
                method: 'post',
                url: '/api/smslote',
                data: params
            }).then(
                response_message_handler.handle,
                response_message_handler.handle
            )

        };
    });