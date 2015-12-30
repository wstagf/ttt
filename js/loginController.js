app.controller('loginController', function ($scope, $http) {
    $scope.login = {
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
                    alert('Verifique usuario ou senha')
                }
            });
    }
})
