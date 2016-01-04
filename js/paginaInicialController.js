app.controller('paginaInicialController', function ($scope, $http, toastr) {
    
    $scope.sair = function () {
        toastr.info('Saindo do sistema', 'Atenção');
        $http.get('api/logout')
        window.location = "index.php"
    }
    
    $scope.pagina = 'homeContent.php';

    $scope.navegar = function (parametro) {
        $scope.pagina = parametro + '.php';
        $scope.listarUsuarios();
        
    }


    
    $scope.addUsuario = false;
    $scope.showAddUsuario = function () {
        $scope.addUsuario = true;
    }
    $scope.showListUsuario = function () {
        $scope.addUsuario = false;
        $scope.listarUsuarios();
    }

    $scope.listaUsuarios = {};
    $scope.listarUsuarios = function () {
        $http.get('api/listarUsuarios')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                console.log(data);
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaUsuarios = data.result;
                    console.log($scope.listaUsuarios);
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                //console.log(data);
                toastr.error('Erro ao localizar Usuarios', 'Erro');
            });
    };



})
