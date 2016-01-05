app.controller('FilialController', function ($scope, $http, toastr) {
    
    $scope.Filial = {
        id: 0,
        descricao: '',
    };

    $scope.FilialAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstFilial = true;
    $scope.addFilial = false;
    $scope.updtFilial = false;

    $scope.showEditarFilial = function () {
        $scope.addFilial = false;
        $scope.lstFilial = false;
        $scope.updtFilial = true;
    };

    $scope.showAddFilial = function () {
        $scope.addFilial = true;
        $scope.lstFilial = false;
        $scope.updtFilial = false;
    };

    $scope.showListFilial = function () {
        $scope.addFilial = false;
        $scope.lstFilial = true;
        $scope.updtFilial = false;
    };

    $scope.inserirFilial = function () {
        $http.post('api/createFilial', $scope.FilialAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.FilialAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Filial adicionado!', 'Sucesso');
                    $scope.listarFilials();
                    $scope.showListFilial();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaFilials = {};
    $scope.listarFilials = function () {
        $http.get('api/listarFilials')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaFilials = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Filiais', 'Erro');
            });
    };

    $scope.editarFilial = function (idFilial) {
        $http.get('api/getFilial/' + idFilial)
            .success(function (data) {
                $scope.Filial = data.Filial;
                $scope.showEditarFilial();
            })
            .error(function (data) {
                toastr.error('Falha em editar Filial', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirFilial = function (idFilial) {
        $http.get('api/excluirFilial/' + idFilial)
            .success(function (data) {
                toastr.success('Filial apagado com sucesso', 'Sucesso');
                $scope.listarFilials();
            })
            .error(function (data) {
                toastr.error('Falha em excluir Filial', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarFilial = function () {
        $http
            .post('api/alterarFilial/' + $scope.Filial.id, $scope.Filial)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Filial atualizado com sucesso', 'Sucesso');
                    $scope.listarFilials();
                    $scope.showListFilial();
                } else {
                    toastr.error('Falha em alterar Filial', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Filial', 'Erro');
                console.log(data);
            });
    };

    $scope.listarFilials();
})
