<div ng-controller="tipoVendaController">  
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
							Tipo de Vendas cadastradas no sistema
						</div>
						<div class="col-lg-2">
							<a href="#" ng-click="showAddTipoVenda()" ng-show="lstTipoVenda"><i class="fa fa-plus-circle fa-fw"></i>AdicionarTipo Venda</a>
							<a href="#" ng-click="showListTipoVenda()" ng-show="addTipoVenda"><i class="fa fa-times-circle fa-fw"></i>Cancelar Adição</a>
							<a href="#" ng-click="showListTipoVenda()" ng-show="updtTipoVenda"><i class="fa fa-times-circle fa-fw"></i>Cancelar Atualização</a>
							
						</div>
					</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" ng-show="lstTipoVenda"> 
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
                                <tr class="odd gradeX" ng-repeat="model in listaTipoVendas track by model.id">
                                    <td>{{model.id}}</td>
                                    <td>{{model.descricao}}</td>
                                    <td class="center">
										<a href="#"  ng-click="editarTipoVenda(model.id)"><i class="fa fa-info-circle fa-fw"></i> Editar</a>
										<a href="#" ng-click="excluirTipoVenda(model.id)"><i class="fa fa-minus-circle fa-fw"></i> Excluir</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="panel-body" ng-show="addTipoVenda">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Registro de Tipo de Vendas</label>
						<form class="form-horizontal" ng-submit="inserirTipoVenda()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Descricao</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Descrição Tipo Venda" ng-model="TipoVendaAdd.descricao" required>
							</div>
							</div>
                          
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Cadastrar Tipo Venda</button>
							</div>
							</div>
						</form>
                    </div>
                </div>
				<div class="panel-body" ng-show="updtTipoVenda">
                    <div class="dataTable_wrapper">
                        <label>Formulario de Edição de Perfil Usuario</label>
						<form class="form-horizontal" ng-submit="alterarTipoVenda()">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">ID</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="ID" ng-model="TipoVenda.id" required>
							</div>
							</div>
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Descricao</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Descrição Tipo Venda" ng-model="TipoVenda.descricao" required>
							</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Atualizar Tipo Venda</button>
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
