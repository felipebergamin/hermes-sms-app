angular.module('hermes_app')
.service('usersAPI', usersAPI);

usersAPI.$inject = ['$http'];


function usersAPI($http) {
    var vm = this;
    var baseurl = '/api/user';

    vm.getAll = function () {
        return $http.get(baseurl);
    };

    vm.get = function (id) {
        if(id !== undefined)
            return $http.get(baseurl + '/' + id);
    };

    vm.store = function (user) {
        if (user)
            return $http.post(baseurl, user);
        return null;
    };

    vm.update = function (user) {
        if(user)
            return $http.put(
                baseurl + '/' + user.id,
                user
            );
    };
}