angular.module('hermes_app')
.service('listabrancaAPI', listabrancaAPI);

listabrancaAPI.$inject = ['$http'];

function listabrancaAPI($http) {
    var vm = this;
    var baseurl = "/api/listabranca";

    vm.delete = function (id) {
        return $http.delete(baseurl+"/"+id);
    };

    vm.store = function (data) {
        return $http.post(baseurl, data);
    };

    vm.loadAll = function () {
        return $http.get(baseurl);
    };

    vm.has = function (val) {
        var url = baseurl + '/consultar/' + val;

        return $http.get(url);
    }
}