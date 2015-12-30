<?php
    session_start();
    if(!isset($_SESSION['logado'])){
        header("Location: index.php");
    }
?>

<html ng-app="app">
    <head>
        <title>SACA - Pagina Inicial</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" >
		<link rel="stylesheet" href="css/angular-toastr.min.css" type="text/css" />
        
    </head>
    <body>
        
        <div ng-controller="paginaInicialController">       
                        
            
          <button type="submit" class="btn btn-default"  ng-click="sair()">Sair</button>  
        </div>

        <script src="js/angular/angular.min.js"></script>
		<script src="js/angular/angular-toastr.tpls.min.js"></script>
        <script src="js/app.module.js"></script>
        <script src="js/paginaInicialController.js"></script>

    </body>
</html>
