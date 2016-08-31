var app = angular.module('hermes_app', ['ui.mask']);

app.controller('sms_ctrl', function ($scope, $http) {
    $scope.url = "/api/sms";

    $scope.clearForm = function () {
        $scope.form.sms = {
            descricao_destinatario: "",
            numero_destinatario: "",
            texto: ""
        };
    };

    $scope.handleErrorResponse = function (response) {
        switch (response.status) {
            case 200:
                console.log("OK");
                break;
            case 422:
                for (var prop in response.data) {
                    toastr.error(response.data[prop]);
                }
        }
    };

    $scope.formSubmit = function () {
        $http({
            method: "post",
            url: $scope.url,
            data: $scope.form.sms
        })
            .then(
                function success(response) {
                    toastr.success("O Sms foi enviado com sucesso!");
                    $scope.clearForm();
                },
                $scope.handleErrorResponse
            )
    };
});