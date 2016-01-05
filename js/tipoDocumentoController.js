app.controller('tipoDocumentoController', function ($scope, $http, toastr) {
    
    $scope.TipoDocumento = {
        id: 0,
        descricao: '',
    };

    $scope.TipoDocumentoAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstTipoDocumento = true;
    $scope.addTipoDocumento = false;
    $scope.updtTipoDocumento = false;

    $scope.showEditarTipoDocumento = function () {
        $scope.addTipoDocumento = false;
        $scope.lstTipoDocumento = false;
        $scope.updtTipoDocumento = true;
    };

    $scope.showAddTipoDocumento = function () {
        $scope.addTipoDocumento = true;
        $scope.lstTipoDocumento = false;
        $scope.updtTipoDocumento = false;
    };

    $scope.showListTipoDocumento = function () {
        $scope.addTipoDocumento = false;
        $scope.lstTipoDocumento = true;
        $scope.updtTipoDocumento = false;
    };

    $scope.inserirTipoDocumento = function () {
        $http.post('api/createTipoDocumento', $scope.TipoDocumentoAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.TipoDocumentoAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Tipo de Documento adicionado!', 'Sucesso');
                    $scope.listarTipoDocumentos();
                    $scope.showListTipoDocumento();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaTipoDocumentos = {};
    $scope.listarTipoDocumentos = function () {
        $http.get('api/listarTipoDocumentos')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaTipoDocumentos = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Tipo de Documento', 'Erro');
            });
    };

    $scope.editarTipoDocumento = function (idTipoDocumento) {
        $http.get('api/getTipoDocumento/' + idTipoDocumento)
            .success(function (data) {
                $scope.TipoDocumento = data.TipoDocumento;
                $scope.showEditarTipoDocumento();
            })
            .error(function (data) {
                toastr.error('Falha em editar Tipo de Documento', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirTipoDocumento = function (idTipoDocumento) {
        $http.get('api/excluirTipoDocumento/' + idTipoDocumento)
            .success(function (data) {
                toastr.success('Tipo de Documento apagado com sucesso', 'Sucesso');
                $scope.listarTipoDocumentos();
            })
            .error(function (data) {
                toastr.error('Falha em excluir Tipo de Documento', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarTipoDocumento = function () {
        $http
            .post('api/alterarTipoDocumento/' + $scope.TipoDocumento.id, $scope.TipoDocumento)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Tipo de Documento atualizado com sucesso', 'Sucesso');
                    $scope.listarTipoDocumentos();
                    $scope.showListTipoDocumento();
                } else {
                    toastr.error('Falha em alterar Tipo de Documento', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Tipo de Documento', 'Erro');
                console.log(data);
            });
    };

    $scope.listarTipoDocumentos();
})
