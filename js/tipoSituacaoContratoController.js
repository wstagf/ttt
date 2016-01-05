app.controller('tipoSituacaoContratoController', function ($scope, $http, toastr) {
    
    $scope.TipoSituacaoContrato = {
        id: 0,
        descricao: '',
    };

    $scope.TipoSituacaoContratoAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstTipoSituacaoContrato = true;
    $scope.addTipoSituacaoContrato = false;
    $scope.updtTipoSituacaoContrato = false;

    $scope.showEditarTipoSituacaoContrato = function () {
        $scope.addTipoSituacaoContrato = false;
        $scope.lstTipoSituacaoContrato = false;
        $scope.updtTipoSituacaoContrato = true;
    };

    $scope.showAddTipoSituacaoContrato = function () {
        $scope.addTipoSituacaoContrato = true;
        $scope.lstTipoSituacaoContrato = false;
        $scope.updtTipoSituacaoContrato = false;
    };

    $scope.showListTipoSituacaoContrato = function () {
        $scope.addTipoSituacaoContrato = false;
        $scope.lstTipoSituacaoContrato = true;
        $scope.updtTipoSituacaoContrato = false;
    };

    $scope.inserirTipoSituacaoContrato = function () {
        $http.post('api/createTipoSituacaoContrato', $scope.TipoSituacaoContratoAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.TipoSituacaoContratoAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Tipo de Situacao de Contrato adicionado!', 'Sucesso');
                    $scope.listarTipoSituacaoContratos();
                    $scope.showListTipoSituacaoContrato();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaTipoSituacaoContratos = {};
    $scope.listarTipoSituacaoContratos = function () {
        $http.get('api/listarTipoSituacaoContratos')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaTipoSituacaoContratos = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Tipo de Situacao de Contrato', 'Erro');
            });
    };

    $scope.editarTipoSituacaoContrato = function (idTipoSituacaoContrato) {
        $http.get('api/getTipoSituacaoContrato/' + idTipoSituacaoContrato)
            .success(function (data) {
                $scope.TipoSituacaoContrato = data.TipoSituacaoContrato;
                $scope.showEditarTipoSituacaoContrato();
            })
            .error(function (data) {
                toastr.error('Falha em editar Tipo de Situacao de Contrato', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirTipoSituacaoContrato = function (idTipoSituacaoContrato) {
        $http.get('api/excluirTipoSituacaoContrato/' + idTipoSituacaoContrato)
            .success(function (data) {
                toastr.success('Tipo de SituacaoContrato apagado com sucesso', 'Sucesso');
                $scope.listarTipoSituacaoContratos();
            })
            .error(function (data) {
                toastr.error('Falha em excluir Tipo de Situacao de Contrato', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarTipoSituacaoContrato = function () {
        $http
            .post('api/alterarTipoSituacaoContrato/' + $scope.TipoSituacaoContrato.id, $scope.TipoSituacaoContrato)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Tipo de Situacao de Contrato atualizado com sucesso', 'Sucesso');
                    $scope.listarTipoSituacaoContratos();
                    $scope.showListTipoSituacaoContrato();
                } else {
                    toastr.error('Falha em alterar Tipo de Situacao de Contrato', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Tipo de Situacao de Contrato', 'Erro');
                console.log(data);
            });
    };

    $scope.listarTipoSituacaoContratos();
})
