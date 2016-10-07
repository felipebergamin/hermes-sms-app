angular.module('hermes_app')
    .controller('gwsms', function ($scope, $http, $timeout, response_message_handler) {

        $scope.credits = {
            loading: false,
            total: 0
        };

        $scope.getCredits = function () {
            $scope.credits.loading = true;

            $http({
                url: '/api/gwsms/credits',
                method: 'get'
            }).then(
                function s(response) {
                    $scope.credits.total = Math.round(response.data.result);
                },
                function f(response) {
                    console.log(response);
                    response_message_handler.handle(response);
                }
            );

            $timeout(function () {
                $scope.credits.loading = false;
            }, 1000);
        };
    });