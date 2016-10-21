angular.module('hermes_app')
.service('relatoriosAPI', relatoriosAPI);

relatoriosAPI.$inject = ['$http'];

function relatoriosAPI($http) {
    var vm = this;
    var baseUrl = '/api/relatorio';
    
    vm.getAll = function () {
        return $http.get(baseUrl);
    };

    vm.getInterval = function (dataInicio, dataFim) {
        if(dataInicio && dataFim)
            return $http.get(baseUrl + '/' + dataInicio + '/' + dataFim);
    };
}