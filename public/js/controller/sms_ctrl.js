var app = angular.module('hermes_app');

app.controller('sms_ctrl', ['$scope', 'smsAPI', 'listabrancaAPI', 'notify', controller]);

function controller($scope, smsAPI, listabrancaAPI, notify) {
    $scope.url = "/api/sms";

    $scope.clearForm = function () {
        $scope.form.sms = {
            descricao_destinatario: "",
            numero_destinatario: "",
            texto: ""
        };
    };

    $scope.checkWhitelist = function (val) {
        listabrancaAPI.has(val)
            .then(
                function (response) {
                    if (response.data === 'true')
                        $scope.form.alertWhiteList = true;
                    else
                        $scope.form.alertWhiteList = false;
                },
                function (response) {
                    console.log(response);
                }
            );
    };

    $scope.formSubmit = function () {

        smsAPI.store($scope.form.sms)
            .then(
                function success(response) {
                    notify.success("O Sms foi enviado com sucesso!");
                    $scope.clearForm();
                },
                function fail(response) {
                    if (response.status === 422)
                        notify.showValidationErrors(response.data);
                    else
                        notify.error(response.message, 'Um erro desconhecido ocorreu!');
                }
            );
    };
}