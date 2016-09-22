angular.module('response_message_handler', []);
angular.module('response_message_handler').provider('response_message_handler', function () {

    this.$get = function () {
        return {
            handle: function (response) {
                switch (response.status) {
                    case 200:
                        toastr.success(response.data.message ? response.data.message : 'Sucesso na operação!');
                        break;
                    case 403:
                        toastr.warning(response.data.message ? response.data.message : 'Parece que você não tem autorização para fazer isso!');
                        break;
                    case 422:
                        for (var prop in response.data)
                            toastr.error(response.data[prop]);
                        break;
                    default:
                        toastr.error(response.data.message ? response.data.message : 'Um erro desconhecido ocorreu!', 'Erro '.concat(response.status));
                }
            }
        };
    };
});