<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Página de teste</h1>
    <?php 
    
    require_once "configuracoes.php";

    try {


        $pessoaDao = new PessoaDao;

        $pessoa = new Pessoa;
        $pessoa->setNome("Rodrigo");
        $pessoa->setNick("@rodrigo");
        $pessoa->setEmail("rodrigo@meudominio.com.br");
        $pessoa->setSenha("supersecreta");

        if(isset($_GET["acao"])) {

            if($_GET["acao"] == "incluir") {
                $pessoaDao->salvar($pessoa);
                echo "Pessoa salva com sucesso!";
            }

            if($_GET["acao"] == "excluir" && isset($_GET["id"])) {
                $id = $_GET["id"];
                $pessoaDao->excluir($id);
                echo "Pessoa excluida com sucesso!";  
            }

        }
        
    } catch (\Throwable $th) {
        "Erro: ". $th->getMessage() ;
    }



    
    ?>

</body>
</html>