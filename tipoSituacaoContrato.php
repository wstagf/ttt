<div ng-controller="tipoSituacaoContratoController">  
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Usuários</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
					<div class="row">
						<div class="col-lg-10">
							Tipo de Agências cadastradas no sistema
						</div>
						<div class="col-lg-2">
							<a href="#" ng-click="showAddTipoSituacaoContrato()" ng-show="lstTipoSituacaoContrato"><i class="fa fa-plus-circle fa-fw"></i>AdicionarTipo SituacaoContrato</a>
							<a href="#" ng-click="showListTipoSituacaoContrato()" ng-show="addTipoSituacaoContrato"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListTipoSituacaoContrato()" ng-show="updtTipoSituacaoContrato"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstTipoSituacaoContrato"> 
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX" ng-repeat="model in listaTipoSituacaoContratos track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricao}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarTipoSituacaoContrato(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirTipoSituacaoContrato(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addTipoSituacaoContrato">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Registro de Tipo de SituacaoContratos</label>
						<form class="form-horizontal" ng-submit="inserirTipoSituacaoContrato()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Descricao</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Descrição Tipo SituacaoContrato" ng-model="TipoSituacaoContratoAdd.descricao" required>
							</div>
							</div>
                          
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Tipo SituacaoContrato</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtTipoSituacaoContrato">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Edição de Perfil Usuario</label>
						<form class="form-horizontal" ng-submit="alterarTipoSituacaoContrato()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">ID</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="ID" ng-model="TipoSituacaoContrato.id" required>
							</div>
							</div>
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Descricao</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Descrição Tipo SituacaoContrato" ng-model="TipoSituacaoContrato.descricao" required>
							</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Tipo SituacaoContrato</button>
							</div>

							</div>
						</form>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.row -->
