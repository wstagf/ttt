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

		$sql = "INSERT INTO usuario (usuario, senha, pass) VALUES ('".$usuario."', '".$senha."', '".$pass."');";
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


$app->run();


