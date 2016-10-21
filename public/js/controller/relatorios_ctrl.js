angular.module('hermes_app')
    .controller('relatorios_ctrl', ['$scope', 'relatoriosAPI', controller]);

function controller($scope, relatoriosAPI) {

    $scope.gerarRelatorio = function () {
        /*
         Adiciona 86400 segundos (1 dia) ao timestamp de dataFim,
         Dessa forma, a pesquisa inclui também registros enviados no último dia do intervalo
         */
        var dataInicio = new Date($scope.form.dataInicio).getTime() / 1000;
        var dataFim = (new Date($scope.form.dataFim).getTime() / 1000) + 86400;

        console.log(dataInicio, dataFim);

        /*
        relatoriosAPI.getInterval(dataInicio, dataFim)
            .then(
                function (response) {
                    $scope.report = response.data;
                },
                function (response) {
                    console.dir(response);
                }
            )
        */
    };

    relatoriosAPI.getAll()
        .then(
            function (response) {
                $scope.report = response.data;
            },
            function (response) {
                console.log(response);
            }
        )
}