<?php include_once './conexao.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPEONATO DE SINUCA</title>
</head>

<body>
    <h1>DAR INICIO AO CAMPEONATO</h1>
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

        <label>Nome do campeonato</label><br>
        <input type="text" name="nomeCamp" id="nomeCamp"><br>

        <label>Premiação do campeonato</label><br>
        <input type="text" name="premiacaoCamp" id="premiacaoCamp"><br>

        <label>Pontuação necessária pra ganhar</label><br>
        <input type="number" name="pontuacaoCamp" id="pontuacaoCamp"><br>

        <label>Regras</label><br>
        <textarea name="regrasCamp" id="regrasCamp"></textarea><br>

        <input type="submit" name="btnCadastrar" id="btnCadastar">




    </form>
</body>

</html>