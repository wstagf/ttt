




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




