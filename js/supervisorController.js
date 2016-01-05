app.controller('SupervisorController', function ($scope, $http, toastr) {
    
    $scope.Supervisor = {
        id: 0,
        descricao: '',
    };

    $scope.SupervisorAdd = {
        id: 0,
        descricao: ''
    };

    
    $scope.lstSupervisor = true;
    $scope.addSupervisor = false;
    $scope.updtSupervisor = false;

    $scope.showEditarSupervisor = function () {
        $scope.addSupervisor = false;
        $scope.lstSupervisor = false;
        $scope.updtSupervisor = true;
    };

    $scope.showAddSupervisor = function () {
        $scope.addSupervisor = true;
        $scope.lstSupervisor = false;
        $scope.updtSupervisor = false;
    };

    $scope.showListSupervisor = function () {
        $scope.addSupervisor = false;
        $scope.lstSupervisor = true;
        $scope.updtSupervisor = false;
    };

    $scope.inserirSupervisor = function () {
        $http.post('api/createSupervisor', $scope.SupervisorAdd)
            .success(function (data) {
                console.log(data);
                if (!data.erro) {
                    $scope.SupervisorAdd = {
                        id: 0,
                        descricao: ''
                    };
                    toastr.success('Supervisor adicionado!', 'Sucesso');
                    $scope.listarSupervisors();
                    $scope.showListSupervisor();
                } else {
                    alert('Deu erro')
                }
            })
            .error(function () {
                toastr.error('Erro no servidor', 'Erro');
            });
    }

       
    $scope.listaSupervisors = {};
    $scope.listarSupervisors = function () {
        $http.get('api/listarSupervisors')
            .success(function (data) {
                //$scope.listaUsuarios = data.$usuarios;
                if (data.result.length == 0) {
                    toastr.info('Não foram encontrados registos', 'Informação');
                } else {
                    $scope.listaSupervisors = data.result;
                }
            })
            .error(function (data) {
                //alert("Falha em obter usuarios");
                console.log(data);
                toastr.error('Erro ao localizar Supervisores', 'Erro');
            });
    };

    $scope.editarSupervisor = function (idSupervisor) {
        $http.get('api/getSupervisor/' + idSupervisor)
            .success(function (data) {
                $scope.Supervisor = data.Supervisor;
                $scope.showEditarSupervisor();
            })
            .error(function (data) {
                toastr.error('Falha em editar Supervisor', 'Erro');
                console.log(data);
            });
    };


    $scope.excluirSupervisor = function (idSupervisor) {
        $http.get('api/excluirSupervisor/' + idSupervisor)
            .success(function (data) {
                toastr.success('Supervisor apagado com sucesso', 'Sucesso');
                $scope.listarSupervisors();
            })
            .error(function (data) {
                toastr.error('Falha em excluir Supervisor', 'Erro');
                console.log(data);
            });
    };

    $scope.alterarSupervisor = function () {
        $http
            .post('api/alterarSupervisor/' + $scope.Supervisor.id, $scope.Supervisor)
            .success(function (data) {

                if (!data.erro) {
                    // deu certo a alteração
                    toastr.success('Supervisor atualizado com sucesso', 'Sucesso');
                    $scope.listarSupervisors();
                    $scope.showListSupervisor();
                } else {
                    toastr.error('Falha em alterar Supervisor', 'Erro');
                    console.log(data);
                }
            })
            .error(function (data) {
                toastr.error('Falha em alterar Supervisor', 'Erro');
                console.log(data);
            });
    };

    $scope.listarSupervisors();
})
