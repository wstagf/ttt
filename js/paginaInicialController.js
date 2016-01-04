app.controller('paginaInicialController', function ($scope, $http, toastr) {
    
    $scope.sair = function () {
        toastr.info('Saindo do sistema', 'Atenção');
        $http.get('api/logout')
        window.location = "index.php"
    }
    
    $scope.pagina = 'homeContent.php';

    $scope.navegar = function (parametro) {
        $scope.pagina = parametro + '.php';
        
    }


    
    $scope.addUsuario = false;
    $scope.showAddUsuario = function () {
        $scope.addUsuario = true;
    }
    $scope.showListUsuario = function () {
        $scope.addUsuario = false;
    }
})
