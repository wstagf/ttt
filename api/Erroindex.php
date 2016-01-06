<?php

require 'Slim/Slim.php';
require 'Db.class.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$db = new Db;

session_start();

header("Content-Type: application/json");


$app->get('/restrito', 'auth', function () use ($app) {
        
        echo json_encode(array("acessou"=>false));
        
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


// Crud USUARIo

// Create
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


// READ - 01: Lista Completa
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

// READ - 02: item unico
$app->get('/getUsuario/:idUsuario', 'auth', function ($idUsuario) use ($app, $db) {
        $idUsuario = (int)$idUsuario;
        $consulta = $db->con()->prepare("select usuario.id, usuario.usuario, usuario.idPerfilUsuario, usuario.status from usuario where usuario.id = :IDUSUARIO");
        $consulta->bindParam(':IDUSUARIO', $idUsuario);
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("usuario"=>$usuarios[0]));
    }
);


// Update
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

// Delete
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


// funções extras
$app->post(
    '/login',
    function () use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $usuario = (isset($data->usuario)) ? $data->usuario : "";
        $senha   = (isset($data->senha)) ? $data->senha : "";
        
        $consulta = $db->con()->prepare("select senha from usuario where usuario = '".$usuario."'");
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


// fim Crud  Usuario




function auth(){
    if(isset($_SESSION['logado'])){
        return true;
    } else {
        $app = \Slim\Slim::getInstance();
        echo json_encode(array("loginerror"=>true,"msg"=>"Acesso Negado"));
        $app->stop();
    }
}



// Crud Perfil Usuario

// Create
$app->post(
    '/createPerfilUsuario',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO perfilusuario (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarPerfilUsuarios', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select perfilusuario.id, perfilusuario.descricao from perfilusuario order by perfilusuario.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app, $db) {
        $idPerfilUsuario = (int)$idPerfilUsuario;
        $consulta = $db->con()->prepare("select perfilusuario.id, perfilusuario.descricao from perfilusuario  where perfilusuario.id = :IDPERFILUSUARIO");
        $consulta->bindParam(':IDPERFILUSUARIO', $idPerfilUsuario);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("perfilusuario"=>$result[0]));
    }
);


// Update
$app->post('/alterarPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idPerfilUsuario = (int)$idPerfilUsuario;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update perfilusuario 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDPERFILUSUARIO');
    
        $consulta->bindParam(':IDPERFILUSUARIO', $idPerfilUsuario);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirPerfilUsuario/:idPerfilUsuario', 'auth', function ($idPerfilUsuario) use ($app, $db) {       
    
        $idPerfilUsuario = (int)$idPerfilUsuario;
        $consulta = $db->con()->prepare("DELETE FROM perfilusuario WHERE id = :IDPERFILUSUARIO");
        $consulta->bindParam(':IDPERFILUSUARIO', $idPerfilUsuario);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud PERFIL  Usuario


// Crud Tipo Agencia

// Create
$app->post(
    '/createTipoAgencia',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO tipoAgencia (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarTipoAgencias', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select tipoagencia.id, tipoagencia.descricao from tipoagencia order by tipoagencia.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getTipoAgencia/:idTipoAgencia', 'auth', function ($idTipoAgencia) use ($app, $db) {
        $idTipoAgencia = (int)$idTipoAgencia;
        $consulta = $db->con()->prepare("select tipoagencia.id, tipoagencia.descricao from tipoagencia  where tipoagencia.id = :IDTIPOAGENCIA");
        $consulta->bindParam(':IDTIPOAGENCIA', $idTipoAgencia);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("TipoAgencia"=>$result[0]));
    }
);


// Update
$app->post('/alterarTipoAgencia/:idTipoAgencia', 'auth', function ($idTipoAgencia) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoAgencia = (int)$idTipoAgencia;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update tipoagencia 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDTIPOAGENCIA');
    
        $consulta->bindParam(':IDTIPOAGENCIA', $idTipoAgencia);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirTipoAgencia/:idTipoAgencia', 'auth', function ($idTipoAgencia) use ($app, $db) {       
    
        $idTipoAgencia = (int)$idTipoAgencia;
        $consulta = $db->con()->prepare("DELETE FROM tipoagencia WHERE id = :IDTIPOAGENCIA");
        $consulta->bindParam(':IDTIPOAGENCIA', $idTipoAgencia);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud TIPO AGENCIA




// Crud Tipo Documento

// Create
$app->post(
    '/createTipoDocumento',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO tipoDocumento (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarTipoDocumentos', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select tipoDocumento.id, tipoDocumento.descricao from tipoDocumento order by tipoDocumento.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getTipoDocumento/:idTipoDocumento', 'auth', function ($idTipoDocumento) use ($app, $db) {
        $idTipoDocumento = (int)$idTipoDocumento;
        $consulta = $db->con()->prepare("select tipoDocumento.id, tipoDocumento.descricao from tipoDocumento  where tipoDocumento.id = :IDTIPODOCUMENTO");
        $consulta->bindParam(':IDTIPODOCUMENTO', $idTipoDocumento);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("TipoDocumento"=>$result[0]));
    }
);


// Update
$app->post('/alterarTipoDocumento/:idTipoDocumento', 'auth', function ($idTipoDocumento) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoDocumento = (int)$idTipoDocumento;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update tipoDocumento 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDTIPODOCUMENTO');
    
        $consulta->bindParam(':IDTIPODOCUMENTO', $idTipoDocumento);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirTipoDocumento/:idTipoDocumento', 'auth', function ($idTipoDocumento) use ($app, $db) {       
    
        $idTipoDocumento = (int)$idTipoDocumento;
        $consulta = $db->con()->prepare("DELETE FROM tipoDocumento WHERE id = :IDTIPODOCUMENTO");
        $consulta->bindParam(':IDTIPODOCUMENTO', $idTipoDocumento);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud TIPO Documento




// Crud Tipo SituacaoContrato

// Create
$app->post(
    '/createTipoSituacaoContrato',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO tipoSituacaoContrato (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarTipoSituacaoContratos', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select tipoSituacaoContrato.id, tipoSituacaoContrato.descricao from tipoSituacaoContrato order by tipoSituacaoContrato.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getTipoSituacaoContrato/:idTipoSituacaoContrato', 'auth', function ($idTipoSituacaoContrato) use ($app, $db) {
        $idTipoSituacaoContrato = (int)$idTipoSituacaoContrato;
        $consulta = $db->con()->prepare("select tipoSituacaoContrato.id, tipoSituacaoContrato.descricao from tipoSituacaoContrato  where tipoSituacaoContrato.id = :IDTIPOSITUACAOCONTRATO");
        $consulta->bindParam(':IDTIPOSITUACAOCONTRATO', $idTipoSituacaoContrato);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("TipoSituacaoContrato"=>$result[0]));
    }
);


// Update
$app->post('/alterarTipoSituacaoContrato/:idTipoSituacaoContrato', 'auth', function ($idTipoSituacaoContrato) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoSituacaoContrato = (int)$idTipoSituacaoContrato;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update tipoSituacaoContrato 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDTIPOSITUACAOCONTRATO');
    
        $consulta->bindParam(':IDTIPOSITUACAOCONTRATO', $idTipoSituacaoContrato);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirTipoSituacaoContrato/:idTipoSituacaoContrato', 'auth', function ($idTipoSituacaoContrato) use ($app, $db) {       
    
        $idTipoSituacaoContrato = (int)$idTipoSituacaoContrato;
        $consulta = $db->con()->prepare("DELETE FROM tipoSituacaoContrato WHERE id = :IDTIPOSITUACAOCONTRATO");
        $consulta->bindParam(':IDTIPOSITUACAOCONTRATO', $idTipoSituacaoContrato);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud TIPO SituacaoContrato



// Crud Tipo Venda

// Create
$app->post(
    '/createTipoVenda',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO tipoVenda (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarTipoVendas', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select tipoVenda.id, tipoVenda.descricao from tipoVenda order by tipoVenda.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getTipoVenda/:idTipoVenda', 'auth', function ($idTipoVenda) use ($app, $db) {
        $idTipoVenda = (int)$idTipoVenda;
        $consulta = $db->con()->prepare("select tipoVenda.id, tipoVenda.descricao from tipoVenda  where tipoVenda.id = :IDTIPOVENDA");
        $consulta->bindParam(':IDTIPOVENDA', $idTipoVenda);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("TipoVenda"=>$result[0]));
    }
);


// Update
$app->post('/alterarTipoVenda/:idTipoVenda', 'auth', function ($idTipoVenda) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idTipoVenda = (int)$idTipoVenda;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update tipoVenda 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDTIPOVENDA');
    
        $consulta->bindParam(':IDTIPOVENDA', $idTipoVenda);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirTipoVenda/:idTipoVenda', 'auth', function ($idTipoVenda) use ($app, $db) {       
    
        $idTipoVenda = (int)$idTipoVenda;
        $consulta = $db->con()->prepare("DELETE FROM tipoVenda WHERE id = :IDTIPOVENDA");
        $consulta->bindParam(':IDTIPOVENDA', $idTipoVenda);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud TIPO Venda






// Crud SUPERVISOR

// Create
$app->post(
    '/createSupervisor',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO Supervisor (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarSupervisors', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select Supervisor.id, Supervisor.descricao from Supervisor order by Supervisor.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getSupervisor/:idSupervisor', 'auth', function ($idSupervisor) use ($app, $db) {
        $idSupervisor = (int)$idSupervisor;
        $consulta = $db->con()->prepare("select Supervisor.id, Supervisor.descricao from Supervisor  where Supervisor.id = :IDSUPERVISOR");
        $consulta->bindParam(':IDSUPERVISOR', $idSupervisor);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("Supervisor"=>$result[0]));
    }
);


// Update
$app->post('/alterarSupervisor/:idSupervisor', 'auth', function ($idSupervisor) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idSupervisor = (int)$idSupervisor;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update Supervisor 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDSUPERVISOR');
    
        $consulta->bindParam(':IDSUPERVISOR', $idSupervisor);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirSupervisor/:idSupervisor', 'auth', function ($idSupervisor) use ($app, $db) {       
    
        $idSupervisor = (int)$idSupervisor;
        $consulta = $db->con()->prepare("DELETE FROM Supervisor WHERE id = :IDSUPERVISOR");
        $consulta->bindParam(':IDSUPERVISOR', $idSupervisor);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud SUPERVISOR







// Crud Filial

// Create
$app->post(
    '/createFilial',
    function () use ($app, $db) {
        $data = json_decode($app->request()->getBody());
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
        $sql = "INSERT INTO Filial (descricao) VALUES ('".$descricao."');";
        $consulta = $db->con()->prepare($sql);
        if($consulta->execute()){
            echo json_encode(array("erro"=>false, "descricao"=>$descricao, "sql" => $sql));
        } else {
            echo json_encode(array("erro"=>true));
        }
    }
);

// READ - 01: Lista Completa
$app->get('/listarFilials', 'auth', function () use ($app, $db) {
        $consulta = $db->con()->prepare("select Filial.id, Filial.descricao from Filial order by Filial.id");
        $consulta->execute();
        if ( $result = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode(array("erro"=>"false", "result"=>$result ));
        } else {
            echo json_encode(array("erro"=>"true", "result"=>$result ));
        }
    }
);

// READ - 02: item unico
$app->get('/getFilial/:idFilial', 'auth', function ($idFilial) use ($app, $db) {
        $idFilial = (int)$idFilial;
        $consulta = $db->con()->prepare("select Filial.id, Filial.descricao from Filial  where Filial.id = :IDFILIAL");
        $consulta->bindParam(':IDFILIAL', $idFilial);
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("Filial"=>$result[0]));
    }
);


// Update
$app->post('/alterarFilial/:idFilial', 'auth', function ($idFilial) use ($app, $db) {
        
        $data = json_decode($app->request()->getBody());
        $idFilial = (int)$idFilial;
        $descricao = (isset($data->descricao)) ? $data->descricao : "";
       
        $consulta = $db->con()->prepare('update Filial 
                                        SET 
                                            descricao = :DESCRICAO
                                        WHERE 
                                            id = :IDFILIAL');
    
        $consulta->bindParam(':IDFILIAL', $idFilial);
        $consulta->bindParam(':DESCRICAO', $descricao);
   
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);



// Delete
$app->get('/excluirFilial/:idFilial', 'auth', function ($idFilial) use ($app, $db) {       
    
        $idFilial = (int)$idFilial;
        $consulta = $db->con()->prepare("DELETE FROM Filial WHERE id = :IDFILIAL");
        $consulta->bindParam(':IDFILIAL', $idFilial);        
    
        if($consulta->execute()){
            echo json_encode(array("erro"=>false));
        } else {
            echo json_encode(array("erro"=>true));
        }
        
    }
);


// fim Crud Filial

$app->run();




