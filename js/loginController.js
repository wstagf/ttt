app.controller('loginController', function ($scope, $http, toastr) {
    $scope.login = {
        usuario: '',
        senha: ''
    };

    $scope.loginAdd = {
        usuario: '',
        senha: ''
    };

    $scope.fazerLogin = function () {
        $http.post('api/login', $scope.login)
            .success(function (data) {
                console.log(data);
                if (data.logado) {
                    window.location = "home.php"
                } else {
                    toastr.info('Verifique o usuário e a senha', 'Atenção');
                }
            });
    }

    $scope.inserirUsuario = function () {
        $http.post('api/registration', $scope.loginAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.loginAdd = {
                        usuario: '',
                        senha: ''
                    };
                    toastr.success('Usuário adicionado!', 'Sucesso');
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

    $scope.sair = function () {
        toastr.info('Saindo do sistema', 'Atenção');
        $http.get('api/logout')
        window.location = "index.php"
    }

})
