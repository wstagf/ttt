app.controller('paginaInicialController', function ($scope, $http, toastr) {
  
    $scope.sair = function () {
        toastr.info('Saindo do sistema', 'Atenção');
        $http.get('api/logout')
        window.location = "index.php"
    }

})
