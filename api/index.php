<?php

require 'Slim/Slim.php';
require 'Db.class.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$db = new Db;

session_start();

header("Content-Type: application/json");


$app->post(
    '/registration',
    function () use ($app, $db) {
		$data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
	    $pass   = (isset($data->senha)) ? $data->senha.'': "" ;
		$senha = md5($pass); 

		$sql = "INSERT INTO usuario (usuario, senha, idPerfilUsuario, status) VALUES ('".$usuario."', '".$senha."', 1, 1);";
		$consulta = $db->con()->prepare($sql);
		if($consulta->execute()){
			echo json_encode(array("erro"=>false, "usuario"=>$usuario,  "pass"=>$pass, "senha"=>$senha, "sql" => $sql));
		} else {
			echo json_encode(array("erro"=>true));
		}
    }
);

$app->post(
    '/login',
    function () use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
	    $senha   = (isset($data->senha)) ? $data->senha : "";
        
		$consulta = $db->con()->prepare("select senha from usuario where usuario = ".$usuario);
        //$consulta->bindParam(':IDNOTICIA', $idnoticia);
        $consulta->execute();
		$result = $consulta->fetchColumn();
        if(md5($senha)==$result){
            $_SESSION['logado']=true;
            echo json_encode(array("logado"=>true, "resposta"=> $result));
        } else {
            echo json_encode(array("logado"=>false, "resposta"=> $result));   
        }
    }
);

$app->get('/restrito', 'auth', function () use ($app) {
        
        echo json_encode(array("acessou"=>false));
        
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

$app->get(
    '/logout',
    function () use ($app) {
        session_destroy();
        exit;
    }
);


$app->get('/listarUsuarios', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select usuario.id, usuario.usuario as descricaoUsuario, perfilusuario.descricao as 'descricaoPefil', usuario.status  from usuario inner join perfilusuario on usuario.idPerfilUsuario = perfilusuario.id;");
        $consulta->execute();
		if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
			echo json_encode(array("erro"=>"false", "result"=>$result ));
		} else {
			echo json_encode(array("erro"=>"true", "result"=>$result ));
		}

    }
);

$app->get('/getUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app, $db) {
        $idUsuario = (int)$idUsuario;
        $consulta = $db->con()->prepare("select usuario.id, usuario.usuario, usuario.idPerfilUsuario, usuario.status from usuario where usuario.id = :IDUSUARIO");
        $consulta->bindParam(':IDUSUARIO', $idUsuario);
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("usuario"=>$usuarios[0]));
    }
);


$app->get('/excluirUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app, $db) {       
    
        $idUsuario = (int)$idUsuario;

        $consulta = $db->con()->prepare("DELETE FROM usuario WHERE id = :IDUSUARIO");
        $consulta->bindParam(':IDUSUARIO', $idUsuario);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


$app->post('/alterarUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idUsuario = (int)$idUsuario;
		$usuario = (isset($data->usuario)) ? $data->usuario : "";
		$idPerfilUsuario = (isset($data->idPerfilUsuario)) ? $data->idPerfilUsuario : "1";
		$status = (isset($data->status)) ? $data->status : "0";
        
        $consulta = $db->con()->prepare('UPDATE usuario 
                                        SET 
                                            usuario = :USUARIO, 
                                            idPerfilUsuario = :IDPERFILUSUARIO, 
                                            status = :STATUS
                                        WHERE 
                                            id = :IDUSUARIO');
    
        $consulta->bindParam(':IDUSUARIO', $idUsuario);
        $consulta->bindParam(':USUARIO', $usuario);
        $consulta->bindParam(':IDPERFILUSUARIO', $idPerfilUsuario);
        $consulta->bindParam(':STATUS', $status);
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);




$app->run();


