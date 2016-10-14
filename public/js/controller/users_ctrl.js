angular.module('hermes_app')
    .controller('users_ctrl', ['$scope', 'notify', 'usersAPI', controller]);


function controller($scope, notify, usersAPI) {
    <!-- ['enviar_sms', 'visualizar_envios', 'visualizar_relatorios', 'manter_usuarios', 'enviar_lote_sms'] -->

    /**
     * Obtem uma lista de todos os usuários e armazena no scopo
     */
    $scope.loadUsers = function () {
        usersAPI.getAll()
            .then(
                function (response) {
                    $scope.users = response.data;
                },
                function (response) {
                    notify.error(response.message, 'Erro ao obter a lista de usuários do servidor!');
                }
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

        usersAPI.update(u)
            .then(
                function (response) {
                    notify.success('Usuário ' + response.data.name + ' desabilitado!');
                },
                function (response) {
                    if (response.status === 422)
                        notify.showValidationErrors(response.data);
                    else
                        notify.error(response.data.message, 'Erro ao desabilitar o usuário!');
                }
            )
    };

    /**
     * Disparado pelo clique no botão "Habilitar usuário"
     * @param u
     */
    $scope.enableUser = function (u) {

        u.habilitado = true;

        usersAPI.update(u)
            .then(
                function (response) {
                    notify.success("Usuário " + response.data.name + " habilitado!");
                },
                function (response) {
                    u.habilitado = false;

                    if (response.status === 422)
                        notify.showValidationErrors(response.data);
                    else
                        notify.error(response.data.message, "Ops! Ocorreu um erro!");
                }
            );
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
        // se o form está cadastrando um novo usuário
        if ($scope.form.function === 'create') {

            $scope.form.user.habilitado = true;

            usersAPI.store($scope.form.user)
                .then(
                    function (response) {
                        $scope.newForm();
                        $scope.users.push(response.data);
                        notify.success('Usuário ' + response.data.name + ' cadastrado!');
                    },
                    function (response) {
                        if (response.status === 422)
                            notify.showValidationErrors(response.data)
                        else
                            notify.error(response.data.message, 'Falha ao cadastrar usuário!');
                    }
                );

        } else if ($scope.form.function === 'update') {
            //se o form está atualizando um usuário

            usersAPI.update($scope.form.user)
                .then(
                    function (response) {
                        $scope.newForm();
                        notify.success('Usuário ' + response.data.name + ' atualizado!');

                        // faz um loop pela lista de usuários bucando o usuário que foi atualizado,
                        // e então atualiza as informações dele
                        for (var i = 0; i < $scope.users.length; i++)
                            if ($scope.users[i].id === response.data.id) {
                                $scope.users[i] = angular.copy(response.data);
                                break;
                            }
                    },
                    function (response) {

                        if (response.status === 422)
                            notify.showValidationErrors(response.data);
                        else
                            notify.error(response.data.message, 'Houve um erro desconhecido!');
                    }
                );
        }
    };
}