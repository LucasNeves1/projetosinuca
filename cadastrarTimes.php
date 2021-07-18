<?php
include_once './conexao.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleCadastrarTimes.css" />
    <title>CADASTRAR TIMES</title>
</head>

<body>
    <h1 class="centralizar">CADASTRO DOS TIMES PARA INICIO DO CAMPEONATO</h1><br>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['btnCadastrar'])) {
        $query_qnt_registros = "SELECT COUNT(id) AS num_result FROM tbtime";
        $result_qnt_registros = $conn->prepare($query_qnt_registros);
        $result_qnt_registros->execute();
        $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

        if (($row_qnt_registros['num_result'] < 10)) {
            echo "<center>Time<strong> " . $dados['nomeTime'] . "</strong> cadastrado com sucesso<br></center>";
            $query_time = "INSERT INTO tbtime (nome, jogador1, jogador2) VALUES ('" . $dados['nomeTime'] . "',
            '" . $dados['nomeJogador1'] . "',
            '" . $dados['nomeJogador2'] . "')";
            $cad_time = $conn->prepare($query_time);
            $cad_time->execute();
        } else {
            echo "<center>Número máximo de times atingido!<br></center>";
        }
    }

    ?>
    <form name="cad-campeonato" method="POST" action="">

        <label class="centralizar">Nome do time:</label>
        <div class="formTimes">
            <input type="text" name="nomeTime" class="labelFormTimes" id="nomeTime" required><br>
        </div>
        <label class="centralizar">Nome do jogador 1:</label>
        <div class="formTimes">
            <input type="text" name="nomeJogador1" class="labelFormTimes" id="nomeJogador1" required><br>
        </div>
        <label class="centralizar">Nome do jogador 2:</label>
        <div class="formTimes">
            <input type="text" name="nomeJogador2" class="labelFormTimes" id="nomeJogador2" required><br>
        </div>

        <div class="centralizar">
            <input type="submit" name="btnCadastrar" id="btnCadastar" class="btnCadastrar" value="Cadastrar"></input>
        </div>
    </form>
    <div class="centralizar"><a href="./listarTimes.php"><button class="btnListimes">TABELA DE TIMES</button></a></div>


</body>

</html>