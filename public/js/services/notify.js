/*
 Classe escrita para intermediar os controllers e a api do Toastr (notificação)

 As funções recebem duas possíveis mensagens para serem exibidas. A primeira é exibida por padrão,
 mas, se a primeira for null ou undefined, a segunda é exibida.

 As funções foram implementadas assim para facilitar no uso das callbacks de $http.
 Em vez de escrever:

 toastr.success( (response.data.message ? data.message : 'Mensagem alternativa') );

 Basta escrever:

 notify.success(response.data.message, 'Mensagem alternativa');
 */

angular.module('hermes_app')
    .service('notify', notify);

function notify() {
    var vm = this;

    vm.messages = {
        200: 'Sucesso!',
        403: 'Parece que você não tem autorização para fazer isso!',
        404: 'Erro 404: Não encontrado!',
        500: 'Erro interno no servidor!'
    };

    /**
     *
     * @param text Texto padrão a ser exibido
     * @param defaultText Texto que será exibido se o primeiro parâmetro for undefined
     */
    vm.success = function (text, defaultText) {
        if (text)
            toastr.success(text);
        else
            toastr.success(defaultText);
    };

    vm.error = function (text, defaultText) {
        if (text)
            toastr.error(text);
        else
            toastr.error(defaultText);
    };

    vm.warning = function (text, defaultText) {
        if (text)
            toastr.warning(text);
        else
            toastr.warning(defaultText);
    };
    
    vm.showValidationErrors = function (data) {
        for (var prop in data)
            vm.error(data[prop], 'Houve um erro desconhecido!');
    };

    vm.errorFromResponse = function (message, response) {
        switch (response.status) {
            case 200:
            case 403:
                vm.warning(response.data.message ? messages[response.status] : 'Parece que você não tem autorização para fazer isso!');
                break;
            case 422:
                for (var prop in response.data)
                    toastr.error(response.data[prop]);
                break;
            default:
                toastr.error(response.data.message ? response.data.message : 'Um erro desconhecido ocorreu!', 'Erro '.concat(response.status));
        }
    }
}