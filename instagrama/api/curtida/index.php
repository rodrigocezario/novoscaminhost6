<?php 
//implementação do nosso serviço REST
session_start();
require_once "../../funcoes.php";
require_once "../../configuracoes.php";

if(isset($_GET["id"])){

    try {
        $usuario = verificaLogado();

        $id = $_GET["id"];
        $dao = new CurtidaDao;
        $curtida = $dao->getCurtidaByPessoa($usuario, $id);

        $retorno = "Curtido a publicação $id";
        $curtiu = false;

        if($curtida) {
            //remover a curtida do post
            $dao->excluir($curtida->getId());
            $retorno = "Removido a curtida da publicação $id";
        }else{

            $publicacaoDao = new PublicacaoDao;
            $publicacao = $publicacaoDao->getPublicacao($id);
            $curtida = new Curtida($usuario, $publicacao);
            $dao->salvar($curtida);
            $curtiu = true;
        }

        $retorno = [
            "success" => true,
            "payload" => [
                "curtiu" => $curtiu,
                "mensagem" => $retorno
            ]
        ];

        http_response_code(201);
        $json = json_encode($retorno);
        echo $json;

    } catch (\Throwable $th) {
        $retorno = [
            "success" => false,
            "payload" => [
                "mensagem" => "Erro ao curtir ". $th->getMessage(),
            ]
        ];
        http_response_code(400);
        $json = json_encode($retorno);
        echo $json;
    }

}


