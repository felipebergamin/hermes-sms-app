angular.module('hermes_app')
    .controller('lista_branca_ctrl', ['$scope', 'listabrancaAPI', 'notify', controller]);

function controller($scope, listabrancaAPI, notify) {

    $scope.init = function () {
        $scope.form = {
            tipos: ['CPF', 'CNPJ', 'CELULAR']
        };

        listabrancaAPI.loadAll()
            .success(
                function (data) {
                    $scope.registros = data;
                }
            )
            .error(
                function (data) {
                    notify.error(data.message, 'Erro ao carregar os registros!');
                    $scope.registros = data;
                }
            );
    };

    $scope.store = function () {
        listabrancaAPI.store($scope.form.model)
            .success(
                function (data, status) {
                    notify.success('Salvo com sucesso!');
                    $scope.registros.push(data);
                    $scope.form.model.descricao = $scope.form.model.valor = '';
                }
            )
            .error(
                function (data, status) {
                    if(status === 422)
                        notify.showValidationErrors(data);
                    else
                        notify.success(data.message, 'Ops! Ocorreu um erro! ' + '(Erro '+status+')' );
                }
            );
    };

    $scope.delete = function (id) {
        listabrancaAPI.delete(id)
            .success(
                function (data) {
                    notify.success(data.message, 'Excluído com sucesso!');
                    removerDaLista($scope.registros, buscarPorId($scope.registros, id));
                }
            )
            .error(
                function (data, status) {
                    notify.error(data.message, 'Ops! Ocorreu um erro! ' + '(Erro '+status+')' );
                }
            );
    };

    var buscarPorId = function (array, id) {
        for (var i = 0; i < array.length; i++)
            if (array[i].id === id)
                return i;
        return -1;
    };

    var removerDaLista = function (array, index) {
        console.log("removendo index " + index);
        if (index >= 0)
            array.splice(index, 1);
    };
}