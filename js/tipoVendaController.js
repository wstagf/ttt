app.controller('tipoVendaController', function ($scope, $http, toastr) {
    
    $scope.TipoVenda = {
        id: 0,
        descricao: '',
    };

    $scope.TipoVendaAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstTipoVenda = true;
    $scope.addTipoVenda = false;
    $scope.updtTipoVenda = false;

    $scope.showEditarTipoVenda = function () {
        $scope.addTipoVenda = false;
        $scope.lstTipoVenda = false;
        $scope.updtTipoVenda = true;
    };

    $scope.showAddTipoVenda = function () {
        $scope.addTipoVenda = true;
        $scope.lstTipoVenda = false;
        $scope.updtTipoVenda = false;
    };

    $scope.showListTipoVenda = function () {
        $scope.addTipoVenda = false;
        $scope.lstTipoVenda = true;
        $scope.updtTipoVenda = false;
    };

    $scope.inserirTipoVenda = function () {
        $http.post('api/createTipoVenda', $scope.TipoVendaAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.TipoVendaAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Tipo de Venda adicionado!', 'Sucesso');
                    $scope.listarTipoVendas();
                    $scope.showListTipoVenda();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaTipoVendas = {};
    $scope.listarTipoVendas = function () {
        $http.get('api/listarTipoVendas')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaTipoVendas = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Tipo de Vendas', 'Erro');
            });
    };

    $scope.editarTipoVenda = function (idTipoVenda) {
        $http.get('api/getTipoVenda/' + idTipoVenda)
            .success(function (data) {
                $scope.TipoVenda = data.result;
                $scope.showEditarTipoVenda();
            })
            .error(function (data) {
                toastr.error('Falha em editar Tipo de Venda', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirTipoVenda = function (idTipoVenda) {
        $http.get('api/excluirTipoVenda/' + idTipoVenda)
            .success(function (data) {
                toastr.success('Tipo de Venda apagado com sucesso', 'Sucesso');
                $scope.listarTipoVendas();
            })
            .error(function (data) {
                toastr.error('Falha em excluir Tipo de Venda', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarTipoVenda = function () {
        $http
            .post('api/alterarTipoVenda/' + $scope.TipoVenda.id, $scope.TipoVenda)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Tipo de Venda atualizado com sucesso', 'Sucesso');
                    $scope.listarTipoVendas();
                    $scope.showListTipoVenda();
                } else {
                    toastr.error('Falha em alterar Tipo de Venda', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Tipo de Venda', 'Erro');
                console.log(data);
            });
    };

    $scope.listarTipoVendas();
})
