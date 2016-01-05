var app = angular.module('app', ['ngSanitize']);

app.controller('verNoticiaController', function($scope, $http, $location){
    
    $scope.noticia = {};
    $scope.fotoMaior = "";
    
    $scope.noticia.idnoticia = $location.search().id;
    
    $scope.getNoticia = function(){
        // getNoticia
        
        $scope.noticias = {};
        
        $http.get('api/getNoticiaFrontend/'+$scope.noticia.idnoticia)
            .success(function(data){
                
                console.log(data);
                $scope.noticia = data.noticias[0].noticia;
            
            })
            .error(function(){
                alert("Falha em obter notícia");
            });
        
    };
    
    $scope.abreFoto = function(foto){
        $scope.fotoMaior = foto;
        $('#verFoto').modal('show');
    };
    
    
    $scope.getNoticia();
    
});

app.config(function($locationProvider){
    $locationProvider.html5Mode({
        enabled : true,
        requireBase : false
    });
});