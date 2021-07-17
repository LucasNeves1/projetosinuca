<?php include_once './conexao.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleIndex.css" />

    <title>CAMPEONATO DE SINUCA</title>
</head>

<body>
    <h1 class="cabecalho">CONFIGURAR CAMPEONATO</h1>
    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['btnCadastrar'])) {
        var_dump($dados);
        $query_camp = "INSERT INTO campeonato (nome, premiacao, pontuacao, regras) VALUES ('" . $dados['nomeCamp'] . "',
        '" . $dados['premiacaoCamp'] . "',
        '" . $dados['pontuacaoCamp'] . "',
        '" . $dados['regrasCamp'] . "')";
        $cad_camp = $conn->prepare($query_camp);
        $cad_camp->execute();
        if ($cad_camp->rowCount()) {
            header("Location: ./principal.php");
        } else {
            echo "Erro";
        }
    }

    ?>
    <form name="cad-campeonato" method="POST" action="">

        <label class="centralizar">Nome do campeonato:</label>
        <div class="formIndex">
            <input type="text" name="nomeCamp" id="nomeCamp" class="labelFormIndex"><br>
        </div>

        <label class="centralizar">Premiação do campeonato:</label>
        <div class="formIndex">
            <input type="text" name="premiacaoCamp" id="premiacaoCamp" class="labelFormIndex"><br>
        </div>

        <label class="centralizar">Pontuação necessária pra ganhar:</label>
        <div class="formIndex">
            <input type="number" name="pontuacaoCamp" id="pontuacaoCamp" class="labelFormIndex"><br>
        </div>
        </div>

        <label class="centralizar">Regras<br></label>
        <div class="centralizar">
            <textarea name="regrasCamp" id="regrasCamp" class="labelFormRegras"></textarea><br>
        </div>
        <div class="centralizar">
            <input type="submit" name="btnCadastrar" id="btnCadastar" class="btnCadastrar" value="INICIAR">
        </div>




    </form>
</body>

</html>