angular.module('hermes_app')
.service('smsAPI', smsAPI);

smsAPI.$inject = ['$http'];

function smsAPI($http) {
    var vm = this;
    var baseUrl = '/api/sms';

    vm.getAll = function () {
        return $http.get(baseUrl);
    };

    vm.get = function (id) {
        return $http.get(baseUrl + '/' + id);
    };

    vm.store = function (data) {
        return $http.post(baseUrl, data);
    }
}