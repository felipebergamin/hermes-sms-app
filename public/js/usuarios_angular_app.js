/**
 * Created by felipe on 22/08/16.
 */

var app = angular.module('hermes_app', []);

app.controller('users_ctrl', function ($scope, $http) {
    $scope.url = '/api/user';

    <!-- ['enviar_sms', 'visualizar_envios', 'visualizar_relatorios', 'manter_usuarios', 'enviar_lote_sms'] -->

    /**
     * Envia para o servidor o objeto passado por parâmetro via requisição POST
     * @param user
     */
    $scope.create = function (user) {
        $http({
            method: 'post',
            url: $scope.url,
            data: user
        }).then(
            function success(response) {
                $scope.users.push(response.data);
                toastr.success('Usuário salvo!');
                $scope.newForm();
            },
            $scope.handleErrorResponse
        );
    };

    /**
     * Envia para o servidor o objeto passado por parâmetro via requisição PUT
     * @param user
     */
    $scope.update = function (user) {
        $http({
            method: 'put',
            url: $scope.url.concat('/', user.id),
            data: user
        }).then(
            function success(response) {
                toastr.success('Usuário alterado!');
                $scope.newForm();

                // se o índice do objeto dentro do array foi informado,
                // e se o id do objeto neste índice é igual ao id do objeto no form
                if ((typeof $scope.form.indexInCollection != 'undefined') && ($scope.users[$scope.form.indexInCollection].id == $scope.form.user.id)) {
                    //se forem o mesmo usuário, atualiza o usuário no array
                    $scope.users[$scope.form.indexInCollection] = angular.copy($scope.form.user);
                } else {
                    // se o índice não foi informado,
                    // ou se não forem o mesmo usuário, faz uma busca no array por um usuário de mesmo id do usuário no form
                    for (var i = 0; i < $scope.users.length; i++) {
                        // se encontrar
                        if ($scope.users[i].id == $scope.form.user.id) {
                            // atualiza o objeto no array
                            $scope.users[i] = angular.copy($scope.form.user);
                            // outras iterações são desnecessárias, interrompe o for
                            break;
                        }
                    }
                }

                return true;
            },
            $scope.handleErrorResponse
        );
    };

    /**
     * Recebe uma resposta de erro do servidor e exibe uma mensagem de erro de acordo com o status http
     * @param response
     */
    $scope.handleErrorResponse = function (response) {
        console.log(response);
        switch (response.status) {
            case 200:
                toastr.info('O servidor retornou status 200, mas a resposta foi tratada como erro! Informe o desenvolvedor!');
                break;
            case 403:
                toastr.error('Parece que você não tem autorização para fazer isso!');
                break;
            case 422:
                for (var prop in response.data)
                    toastr.error(response.data[prop]);
                break;
            case 500:
                toastr.error('Ops! Ocorreu um erro interno no servidor!');
                break;
            default:
                toastr.error('Um erro desconhecido ocorreu! Atualize a página!', 'Erro '.concat(response.status));
        }
        ;
    };

    /**
     * Obtem uma lista de todos os usuários e armazena no scopo
     */
    $scope.loadUsers = function () {
        $http({
            method: 'get',
            url: '/api/user'
        }).then(
            function success(response) {
                $scope.users = response.data;
            },
            $scope.handleErrorResponse
        );
    };

    /**
     * Zera todas as variáveis do form, limpando seus campos e restaura seu estado para "create"
     */
    $scope.newForm = function () {
        $scope.form = {
            function: 'create',
            user: {
                name: '',
                email: '',
                password: '',
                password_confirm: '',
                habilitado: 1,
                permissoes: {
                    enviar_sms: true,
                    enviar_lote_sms: false,
                    manter_usuarios: false,
                    visualizar_envios: false,
                    visualizar_relatorios: false
                }
            }
        };
    };

    /**
     * Inicializa o formulário e carrega a lista de usuários
     */
    $scope.init = function () {
        $scope.loadUsers();
        $scope.newForm();
    };

    /**
     * Disparado pelo clique no botão "Habilitar usuário"
     * @param u
     */
    $scope.disableUser = function (u) {
        u.habilitado = false;

        $scope.update(u);
    };

    /**
     * Disparado pelo clique no botão "Habilitar usuário"
     * @param u
     */
    $scope.enableUser = function (u) {
        u.habilitado = true;

        $scope.update(u);
    };

    /**
     * Disparado quando o botão "Alterar usuário" é clicado,
     * essa função prepara o formulário para alterar os dados do usuário selecionado
     *
     * @param user O objeto user a ser alterado
     * @param index O indice do usuario na collection.
     */
    $scope.editUser = function (user, index) {
        $scope.form.function = 'update';

        $scope.form.user = angular.copy($scope.users[index]);
        $scope.form.indexInCollection = index;
    };

    /**
     * Disparado pelo ng-submit do form.
     */
    $scope.formSubmit = function () {
        // se o form está atualizando um usuário
        if ($scope.form.function === 'create') {
            $scope.form.user.habilitado = true;
            $scope.create($scope.form.user);
        } else if ($scope.form.function === 'update') {
            //se o form está atualizando um usuário
            $scope.update($scope.form.user);
        }
    };
})
;