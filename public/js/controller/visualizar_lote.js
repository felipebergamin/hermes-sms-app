angular.module('hermes_app')
    .controller('visualizar_lote', function ($scope, $http, response_message_handler) {
        $scope.lista_lotes = [];

        $scope.pagination = {
            current_page: 0,
            page_length: 15,
            totalPages: function () {
                if ($scope.lista_lotes)
                    return Math.ceil($scope.lista_lotes.length / this.page_length); //Math.ceil arredonda sempre para cima
                return 0;
            },
            nextPage: function () {
                // se há uma próxima página
                if (this.current_page+1 < this.totalPages())
                    this.current_page++;
            },
            previousPage: function () {
                // se há uma página anterior
                if (this.current_page-1 >= 0)
                    this.current_page--;
            }
        };

        $scope.doSearch = function () {

            var start = new Date($scope.search.startDate).getTime()/1000;

            /*
             Adiciona 86400 segundos (1 dia) ao timestamp,
             Dessa forma, a pesquisa inclui também registros enviados no último dia do intervalo selecionado
             */
            var end = (new Date($scope.search.endDate).getTime()/1000) + (86400);

            $http({
                method: 'get',
                url: '/api/smslote/search/dateinterval',
                params: { start: start, end: end }
            }).then(
                function s(response) {
                    $scope.lista_lotes = response.data;
                    toastr.info($scope.lista_lotes.length + " registros encontrados!");
                },
                response_message_handler.handle
            );
        };
    });
