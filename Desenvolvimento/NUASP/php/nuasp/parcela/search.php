<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    //include_once '../config/core.php';
    include_once '../config/database.php';
    include_once '../objects/parcelas.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $parcelas = new Parcelas($db);
    
    // Pegar keywords
    $keywords=isset($_GET["s"]) ? $_GET["s"] : "";
    
    // Query
    $stmt = $parcelas->search($keywords);
    $num = $stmt->rowCount();
    
    if($num>0){
    
        // Parcelas array
        $parcelas_arr=array();
        $parcelas_arr["records"]=array();
    
        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
    
            $parcela_item = array(
                "id" => $id,
                "dividaId" => $dividaId,
                "numeroParcela" => $numeroParcela,
                "dataVencimento" => $dataVencimento,
                "valorParcela" => $valorParcela,
                "dividaParcelas" => $dividaParcelas,
                "dividaValor" => $dividaValor,
                "dividaIsPaga" => $dividaIsPaga,
                "alunoId" => $alunoId,
                "instituicaoId" => $instituicaoId,
                "tipoPagamentoId" => $tipoPagamentoId,
                "instituicaoCnpj" => $instituicaoCnpj,
                "instituicaoNome" => $instituicaoNome,
                "alunoNome" => $alunoNome,
                "alunoCpf" => $alunoCpf,
                "alunoEmail" => $alunoEmail,
                "tipoPagamentoNome" => $tipoPagamentoNome
            );
    
            array_push($parcelas_arr["records"], $parcela_item);
        }
    
        http_response_code(200);
        echo json_encode($parcelas_arr);
    }
    
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "Registro não encontrado.")
        );
    }
?>