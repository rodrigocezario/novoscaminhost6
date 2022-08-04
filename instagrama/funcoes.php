<?php 

$PASTA_UPLOAD = "fotos/";
$TAMANHO_NOME_ARQUIVO = 10;
$TIPOS_PERMITIDOS = ["jpg", "jpeg", "png", "gif"];

function uploadFotos($fileUpload) {
    global $TAMANHO_NOME_ARQUIVO, $PASTA_UPLOAD, $TIPOS_PERMITIDOS;
    $nome_arquivo = gerarFotoNome($TAMANHO_NOME_ARQUIVO);
    $arquivo = $PASTA_UPLOAD . basename($fileUpload["name"]);
    $arquivo_tipo = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));

    if(!in_array($arquivo_tipo, $TIPOS_PERMITIDOS)){
        throw new Exception("Tipo de arquivo enviado não é permitido!");
    }

    //fotos/abcd.png
    $foto = $nome_arquivo . "." . $arquivo_tipo;

    if(!move_uploaded_file($fileUpload["tmp_name"], $PASTA_UPLOAD . $foto)) {
        throw new Exception("Não foi possível realizar o upload da foto!");
    }

    return $foto;
}


function gerarFotoNome($tamanho) {
    $chars = "abcdefghijklmnopqrstuvwxyz012_";
    $var_size = strlen($chars);
    $nome = "";
    for($i = 0; $i < $tamanho; $i++){
        $nome .= $chars[rand(0, $var_size - 1)];
    }
    return $nome;
}