angular.module('hermes_app')
    .controller('lista_branca_ctrl', function ($scope, $http, response_message_handler) {

        $scope.form = {
            tipos: ['CPF', 'CNPJ', 'CELULAR']
        };

        // carrega os registros na lista branca
        $http({
            method: "get",
            url: "/api/listabranca"
        }).then(
            function s(response) {
                $scope.registros = response.data;
            },
            function f(response) {
                response_message_handler(response);
                console.dir(response);
            }
        );

        $scope.debug = function () {
            console.log('Debug:');
            console.dir($scope.form.model);
        };

        $scope.store = function () {
            console.dir($scope.form.model);

            $http({
                method: "post",
                url: "/api/listabranca",
                data: $scope.form.model
            }).then(
                function s(response) {
                    toastr.success("Salvo com sucesso!");
                    $scope.registros.push(response.data);
                    $scope.form.model.descricao = $scope.form.model.valor = '';
                },
                function f(response) {
                    response_message_handler.handle(response);
                    console.dir(response);
                }
            )
        };

        $scope.delete = function (id) {

            $http({
                method: "delete",
                url: "/api/listabranca/" + id
            }).then(
                function s(response) {
                    toastr.success((response.data.message ? response.data.message : 'Removido com sucesso!'));

                    for(var i = 0; i < $scope.registros.length; i++) {
                        if($scope.registros[i].id === id)
                            $scope.registros.splice(i, 1);
                    }
                },
                function f(response) {
                    response_message_handler.handle(response);
                    console.dir(response);
                }
            )
        }
    });