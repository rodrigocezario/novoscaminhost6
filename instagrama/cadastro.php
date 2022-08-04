<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    
    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <form action="cadastro.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control">
            </div>

            <div class="mb-3">
                <label for="nick" class="form-label">Nickname</label>
                <input type="text" name="nick" id="nick" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>

            <div class="d-flex justify-content-between w-100">

                <div class="mb-3 w-50 pe-1">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control">
                </div>

                <div class="mb-3 w-50 ps-1">
                    <label for="confsenha" class="form-label">Confirme a Senha</label>
                    <input type="password" name="confsenha" id="confsenha" class="form-control">
                </div>

            </div>

            <div class="my-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">Salvar</button>
            </div>

        </form>

        <?php 
        
        require_once "configuracoes.php";
        require_once "funcoes.php";

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            try {
                $pessoa = new Pessoa;
                $dao = new PessoaDao;

                //desafio: realizar o tratamentos verificando a existencia do valor
                //desafio 2: usar DTO
                $pessoa->setNome($_POST["nome"]);
                $pessoa->setNick($_POST["nick"]);
                $pessoa->setEmail($_POST["email"]);

                if(!($_POST["senha"] == $_POST["confsenha"])) {
                    throw new Exception("As senhas informadas são diferentes!");
                }
                $pessoa->setSenha($_POST["senha"]);

                $foto = uploadFotos($_FILES["foto"]);
                $pessoa->setFoto($foto);
                
                $dao->salvar($pessoa);

                echo "Usuário cadastrado com sucesso!";

            } catch (\Throwable $th) {
                echo "Erro: ". $th->getMessage();
            }

        }
        
        ?>

    </div>

</body>
</html>