app.controller('inicialController', function($scope, $http){
    
    $scope.getNoticias = function(){
        // getNoticia
        
        $scope.noticias = {};
        
        $http.get('api/getNoticiaFrontend')
            .success(function(data){
                
                $scope.noticias = data.noticias;
            
            })
            .error(function(){
                alert("Falha em obter notícia");
            });
        
    };
    
    $scope.getNoticias();
    
});