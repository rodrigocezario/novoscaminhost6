<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teste conexão banco de dados</h1>

    <?php 
    
    require "dao/conexao.php";

    try {
        $conexao = Conexao::getConnection();
        echo "Conexão realizada com sucesso!";

    } catch (\Throwable $e) {
        echo "Erro ao conectar com banco de dados: ". $e->getMessage();
    }

    ?>

</body>
</html>