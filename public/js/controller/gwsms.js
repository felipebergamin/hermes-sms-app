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
                    $scope.credits.total = response.data.result;
                },
                response_message_handler.handle
            );

            $timeout(function () {
                $scope.credits.loading = false;
            }, 1000);
        };
    });