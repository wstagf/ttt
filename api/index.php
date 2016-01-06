<?php
require 'Slim/Slim.php';
require 'Db.class.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
function createDB() {
    //return mysql_connect("mysql01.aguiarobo.hospedagemdesites.ws", "aguiarobo", "aguiarobo");
	//return mysql_connect("127.0.0.1", "root", "");

	$dblink = mysql_connect("127.0.0.1", "root", "");
	if (mysql_errno($dblink) > 0 ) {
        echo mysql_errno($dblink) . ": " . mysql_error($dblink). "\n";
    } else {
	    //mysql_select_db("aguiarobo", $dblink);
		mysql_select_db("angularnoticiasv1", $dblink);
		if (mysql_errno($dblink) > 0 ) {
            echo mysql_errno($dblink) . ": " . mysql_error($dblink). "\n";
        } else {
		return $dblink;
		}
	}

}
session_start();
header("Content-Type: application/json");
$app->post(
    '/login',
    function () use ($app) {
        $data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $senha   = (isset($data->senha)) ? $data->senha : "";
        $link =createDB();
        
		$result =  mysql_query("select senha from usuario where usuario = '".$usuario."'", $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("logado"=>false, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link)));
        } else {
            $row = mysql_fetch_assoc($result);
            if (!$row) {
                echo json_encode(array("logado"=>false, "resposta"=> 'usuario não encontrado'));  
            }   else {
                if(md5($senha)==$row['senha']){
                    $_SESSION['logado']=true;
                    echo json_encode(array("logado"=>true));
                } else {
                    echo json_encode(array("logado"=>false));   
                }
            }        
        }
		 mysql_close($link);
    }
);

$app->get(
    '/logout',
    function () use ($app) {
        session_destroy();
        header("Location: index.php");
        exit;
    }
);
function auth(){
    if(isset($_SESSION['logado'])){
        return true;
    } else {
        $app = \Slim\Slim::getInstance();
        echo json_encode(array("loginerror"=>true,"msg"=>"Acesso Negado"));
        $app->stop();
    }
}


// Crud USUARIo
$app->post(
    '/registration',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $pass   = (isset($data->senha)) ? $data->senha.'': "" ;
        $senha = md5($pass); 
        $link =createDB();
       
		$sql = "INSERT INTO usuario (usuario, senha, idPerfilUsuario, status) VALUES ('".$usuario."', '".$senha."', 1, 1);";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "usuario"=>$usuario,  "pass"=>$pass, "senha"=>$senha));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarUsuarios', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select usuario.id, usuario.usuario as descricaoUsuario, perfilusuario.descricao as 'descricaoPefil', usuario.status  from usuario inner join perfilusuario on usuario.idPerfilUsuario = perfilusuario.id;";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app) {
        $idUsuario = (int)$idUsuario;
		$link = createDB();
		$sql = "select usuario.id, usuario.usuario, usuario.idPerfilUsuario, usuario.status from usuario where usuario.id = ".$idUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idUsuario = (int)$idUsuario;
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $idPerfilUsuario = (isset($data->idPerfilUsuario)) ? $data->idPerfilUsuario : "1";
        $status = (isset($data->status)) ? $data->status : "0";
        
		$link =createDB();
        
		$sql = "UPDATE usuario   SET  usuario = '".$usuario."', idPerfilUsuario = ".$idPerfilUsuario.", status = ".$status." WHERE  id = ".$idUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app) {       
		$idUsuario = (int)$idUsuario;
        $link =createDB();
        
        $sql = "DELETE FROM usuario WHERE id = ".$idUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Usuario





// Crud Perfil Usuario
$app->post(
    '/createPerfilUsuario',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO perfilusuario (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarPerfilUsuarios', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select perfilusuario.id, perfilusuario.descricao from perfilusuario order by perfilusuario.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app) {
		$idPerfilUsuario = (int)$idPerfilUsuario;
		$link = createDB();
		$sql = "select perfilusuario.id, perfilusuario.descricao from perfilusuario  where perfilusuario.id = ".$idPerfilUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idPerfilUsuario = (int)$idPerfilUsuario;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE perfilusuario  SET  descricao = '".$descricao."' WHERE  id = ".$idPerfilUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app) {       
		$idPerfilUsuario = (int)$idPerfilUsuario;
        $link =createDB();
        
        $sql = "DELETE FROM perfilusuario WHERE id = ".$idPerfilUsuario.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Perfil Usuario




// Crud Tipo Agencia
$app->post(
    '/createTipoAgencia',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO tipoAgencia (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarTipoAgencias', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select tipoagencia.id, tipoagencia.descricao from tipoagencia order by tipoagencia.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getTipoAgencia/:idTipoAgencia', 'auth', function ($idTipoAgencia) use ($app) {
		$idTipoAgencia = (int)$idTipoAgencia;
		$link = createDB();
		$sql = "select tipoagencia.id, tipoagencia.descricao from tipoagencia  where tipoagencia.id = ".$idTipoAgencia.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarTipoAgencia/:idTipoAgencia', 'auth', function ($idTipoAgencia) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoAgencia = (int)$idTipoAgencia;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE tipoagencia  SET  descricao = '".$descricao."' WHERE  id = ".$idTipoAgencia.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirTipoAgencia/:idTipoAgencia', 'auth', function ($idTipoAgencia) use ($app) {       
		$idTipoAgencia = (int)$idTipoAgencia;
        $link =createDB();
        
        $sql = "DELETE FROM tipoagencia WHERE id = ".$idTipoAgencia.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Tipo Agencia



// Crud Tipo Documento
$app->post(
    '/createTipoDocumento',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO tipoDocumento (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarTipoDocumentos', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select tipoDocumento.id, tipoDocumento.descricao from tipoDocumento order by tipoDocumento.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getTipoDocumento/:idTipoDocumento', 'auth', function ($idTipoDocumento) use ($app) {
		$idTipoDocumento = (int)$idTipoDocumento;
		$link = createDB();
		$sql = "select tipoDocumento.id, tipoDocumento.descricao from tipoDocumento  where tipoDocumento.id = ".$idTipoDocumento.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarTipoDocumento/:idTipoDocumento', 'auth', function ($idTipoDocumento) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoDocumento = (int)$idTipoDocumento;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE tipoDocumento  SET  descricao = '".$descricao."' WHERE  id = ".$idTipoDocumento.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirTipoDocumento/:idTipoDocumentoa', 'auth', function ($idTipoDocumento) use ($app) {       
		$idTipoDocumento = (int)$idTipoDocumento;
        $link =createDB();
        
        $sql = "DELETE FROM tipoDocumento WHERE id = ".$idTipoDocumento.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Tipo Documento


// Crud Tipo SituacaoContrato
$app->post(
    '/createTipoSituacaoContrato',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO tipoSituacaoContrato (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarTipoSituacaoContratos', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select tipoSituacaoContrato.id, tipoSituacaoContrato.descricao from tipoSituacaoContrato order by tipoSituacaoContrato.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getTipoSituacaoContrato/:idTipoSituacaoContrato', 'auth', function ($idTipoSituacaoContrato) use ($app) {
		$idTipoSituacaoContrato = (int)$idTipoSituacaoContrato;
		$link = createDB();
		$sql = "select tipoSituacaoContrato.id, tipoSituacaoContrato.descricao from tipoSituacaoContrato  where tipoSituacaoContrato.id = ".$idTipoSituacaoContrato.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarTipoSituacaoContrato/:idTipoSituacaoContrato', 'auth', function ($idTipoSituacaoContrato) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoSituacaoContrato = (int)$idTipoSituacaoContrato;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE tipoSituacaoContrato  SET  descricao = '".$descricao."' WHERE  id = ".$idTipoSituacaoContrato.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirTipoSituacaoContrato/:idTipoSituacaoContrato', 'auth', function ($idTipoSituacaoContrato) use ($app) {       
		$idTipoSituacaoContrato = (int)$idTipoSituacaoContrato;
        $link =createDB();
        
        $sql = "DELETE FROM tipoSituacaoContrato WHERE id = ".$idTipoSituacaoContrato.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Tipo SituacaoContrato



// Crud Tipo vendas
$app->post(
    '/createTipoVenda',
    function () use ($app) {
		$data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";

        $link =createDB();
       
		$sql = "INSERT INTO tipoVenda (descricao) VALUES ('".$descricao."');";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
            } 
        }
		 mysql_close($link);
    }
);
// READ - 01: Lista Completa
$app->get('/listarTipoVendas', 'auth', function () use ($app) {
		$link = createDB();
		$sql = "select tipoVenda.id, tipoVenda.descricao from tipoVenda order by tipoVenda.id";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows ));
        }
		 mysql_close($link);
    }
);
// READ - 02: item unico
$app->get('/getTipoVenda/:idTipoVenda', 'auth', function ($idTipoVenda) use ($app) {
		$idTipoVenda = (int)$idTipoVenda;
		$link = createDB();
		$sql = "select tipoVenda.id, tipoVenda.descricao from tipoVenda  where tipoVenda.id = ".$idTipoVenda.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
			$rows = array();
			while ($row = mysql_fetch_array($result, MYSQL_BOTH))
			{
				$rows[] = $row;
			}
			echo json_encode(array("erro"=>"false", "result"=>$rows[0] ));
        }
		 mysql_close($link);
    }
);
// Update
$app->post('/alterarTipoVenda/:idTipoVenda', 'auth', function ($idTipoVenda) use ($app) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoVenda = (int)$idTipoVenda;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
		$link =createDB();
        
		$sql = "UPDATE tipoVenda  SET  descricao = '".$descricao."' WHERE  id = ".$idTipoVenda.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
        
    }
);
// Delete
$app->get('/excluirTipoVenda/:idTipoVenda', 'auth', function ($idTipoVenda) use ($app) {       
		$idTipoVenda = (int)$idTipoVenda;
        $link =createDB();
        
        $sql = "DELETE FROM tipoVenda WHERE id = ".$idTipoVenda.";";
		$result =  mysql_query($sql, $link);
        if (mysql_errno($link) > 0 ) {
			echo json_encode(array("erro"=>true, "mysql_errno" => mysql_errno($link), "mysql_error" => mysql_error($link), "sql" => $sql));
        } else {
            if ($result) {
                echo json_encode(array("erro"=>false));
            } 
        }
		 mysql_close($link);
    }
);
// fim Crud  Tipo vendas


$app->run();
