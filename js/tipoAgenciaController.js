app.controller('tipoAgenciaController', function ($scope, $http, toastr) {
    
    $scope.TipoAgencia = {
        id: 0,
        descricao: '',
    };

    $scope.TipoAgenciaAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstTipoAgencia = true;
    $scope.addTipoAgencia = false;
    $scope.updtTipoAgencia = false;

    $scope.showEditarTipoAgencia = function () {
        $scope.addTipoAgencia = false;
        $scope.lstTipoAgencia = false;
        $scope.updtTipoAgencia = true;
    };

    $scope.showAddTipoAgencia = function () {
        $scope.addTipoAgencia = true;
        $scope.lstTipoAgencia = false;
        $scope.updtTipoAgencia = false;
    };

    $scope.showListTipoAgencia = function () {
        $scope.addTipoAgencia = false;
        $scope.lstTipoAgencia = true;
        $scope.updtTipoAgencia = false;
    };

    $scope.inserirTipoAgencia = function () {
        $http.post('api/createTipoAgencia', $scope.TipoAgenciaAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.TipoAgenciaAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Tipo de Agencia adicionado!', 'Sucesso');
                    $scope.listarTipoAgencias();
                    $scope.showListTipoAgencia();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaTipoAgencias = {};
    $scope.listarTipoAgencias = function () {
        $http.get('api/listarTipoAgencias')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaTipoAgencias = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Tipo de Agencia', 'Erro');
            });
    };

    $scope.editarTipoAgencia = function (idTipoAgencia) {
        $http.get('api/getTipoAgencia/' + idTipoAgencia)
            .success(function (data) {
                $scope.TipoAgencia = data.result;
                $scope.showEditarTipoAgencia();
            })
            .error(function (data) {
                toastr.error('Falha em editar Tipo de Agencia', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirTipoAgencia = function (idTipoAgencia) {
        $http.get('api/excluirTipoAgencia/' + idTipoAgencia)
            .success(function (data) {
                toastr.success('Tipo de Agencia apagado com sucesso', 'Sucesso');
                $scope.listarTipoAgencias();
            })
            .error(function (data) {
                toastr.error('Falha em excluir Tipo de Agencia', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarTipoAgencia = function () {
        $http
            .post('api/alterarTipoAgencia/' + $scope.TipoAgencia.id, $scope.TipoAgencia)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Tipo de Agencia atualizado com sucesso', 'Sucesso');
                    $scope.listarTipoAgencias();
                    $scope.showListTipoAgencia();
                } else {
                    toastr.error('Falha em alterar Tipo de Agencia', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Tipo de Agencia', 'Erro');
                console.log(data);
            });
    };

    $scope.listarTipoAgencias();
})
