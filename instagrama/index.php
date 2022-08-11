<?php

session_start();

require_once "configuracoes.php";
require_once "funcoes.php";

//remover
//$_SESSION["USUARIO"] = "Rodrigo";
$usuario = verificaLogado(); //chamada da função

//isset($_SESSION["USUARIO"])

// if (isset($_SESSION["USUARIO"])){
//     echo "Usuário existe";
// }else {
//     echo "Usuário NÃO existe"; 
// }

if (isset($_GET["acao"])) {
    if ($_GET["acao"] == "sair") {
        session_destroy(); //removendo todas as variáveis de sessão
        header("Location: login.php");
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Instagrama</title>
    <style>
        .circular {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 50%;
        }

        .circular-sm {
            width: 40px;
            height: 40px;
        }

        .circular img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <script>
        async function curtir(publicacao) {
            const retorno = await enviaPost(`api/curtida/?id=${publicacao}`, 'GET', null);

            console.log(retorno);

            const coracao = document.querySelector(`#coracao_${publicacao}`);
            const contador = document.querySelector(`#curtida_cont_${publicacao}`);

            if (retorno.success) {
                coracao.style.fill = (retorno.payload.curtiu) ? 'red' : 'gray';
                //bug... tem que obter o valor do contador
                let cont = contador.innerHTML;
                contador.innerHTML = (retorno.payload.curtiu) ? parseInt(cont) + 1 : parseInt(cont) - 1;
            }
        }

        async function enviaPost(url, method, data) {

            let fetchData = {
                method: method,
                body: data,
                headers: new Headers()
            }

            const retorno = await fetch(url, fetchData)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    return data;
                })
                .catch(function(err) {
                    console.error(err);
                });
            return retorno;
        }
    </script>
</head>

<body>

    <div class="container">

        <section>
            <nav class="d-flex justify-content-end">
                <div class="w-100">
                    <h1>
                        <?php echo $usuario->getNome(); ?>
                    </h1>
                </div>
                <div class="my-2">
                    ação
                </div>
                <div class="my-2 ms-2">
                    <a href="index.php?acao=sair">Sair</a>
                </div>
            </nav>
        </section>

        <div>
            <form action="index.php" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="foto" class="form-label">Arquivo</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                </div>

                <div class="form-floating">
                    <textarea class="form-control" placeholder="Adicione um comentário para sua foto" id="comentario" name="comentario" style="height: 100px"></textarea>
                    <label for="comentario">Comentário</label>
                </div>

                <div class="my-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Enviar</button>
                </div>

            </form>

            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                try {
                    $publicacaoDao = new PublicacaoDao;

                    $publicacao = new Publicacao($usuario);
                    $foto = uploadFotos($_FILES["foto"]);
                    $publicacao->setFoto($foto);
                    $publicacao->setTexto($_POST["comentario"]);

                    $publicacaoDao->salvar($publicacao);

                    echo "<div class='alert alert-success' role='alert'>
                    Post realizado com sucesso!
                    </div>";
                } catch (\Throwable $th) {
                    echo "<div class='alert alert-danger' role='alert'>
                    Erro ao postar: " . $th->getMessage() . "
                    </div>";
                }
            }

            ?>

        </div>

        <?php

        $publicacaoDao = new PublicacaoDao;
        $publicacoes = $publicacaoDao->listar($usuario);

        ?>

        <ul>
            <?php
            $curtidaDao = new CurtidaDao;

            foreach ($publicacoes as $item) {

                $foto = $item->getAutor()->getFoto();
                $foto = $foto ? $foto : "no_avatar.jpeg";
                $data = new DateTime($item->getData());
            ?>
                <li>

                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex justify-content-start my-1">
                            <div class="circular circular-sm">
                                <img src="fotos/<?php echo $foto; ?>" alt="">
                            </div>
                            <div class="p-2">
                                <?php echo $item->getAutor()->getNome(); ?>
                            </div>
                        </div>
                        <div class="py-2">
                            <?php echo $data->format("d/m/Y H:i:s"); ?>
                        </div>
                    </div>

                    <div>
                        <img src="fotos/<?php echo $item->getFoto(); ?>" alt="" class="img-fluid w-100" style="border-radius: 20px;">
                    </div>

                    <?php 
                    $curti = $curtidaDao->getCurtidaByPessoa($usuario, $item->getId());
                    $cor = ($curti == null)? "gray" : "red";
                    ?>

                    <div class="d-flex">
                        <div class="px-1">
                            <button type="button" class="btn border-0" onclick="curtir(<?php echo $item->getId(); ?>)">
                                <svg id="coracao_<?php echo $item->getId(); ?>" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="<?php echo $cor;?>" class="bi bi-heart-fill" viewBox="0 0 18 18">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                                </svg>
                            </button>
                        </div>
                        <div class="d-flex">
                            <span class="py-1 me-1" id="curtida_cont_<?php echo $item->getId(); ?>"><?php echo $item->getTotalCurtida(); ?></span>
                            <span class="py-1">curtidas</span>
                        </div>
                    </div>
                    <div class="d-block pb-2 mb-3">
                        <?php echo $item->getTexto(); ?>
                    </div>
                </li>
            <?php
            } //fim do foreach
            ?>
        </ul>

    </div>
</body>

</html>