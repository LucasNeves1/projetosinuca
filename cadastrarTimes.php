<?php
include_once './conexao.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>CADASTRO DOS TIMES PARA INICIO DO CAMPEONATO</h1><br>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['btnCadastrar'])) {
        $query_time = "INSERT INTO tbtime (nome, jogador1, jogador2) VALUES ('" . $dados['nomeTime'] . "',
        '" . $dados['nomeJogador1'] . "',
        '" . $dados['nomeJogador2'] . "')";
        $cad_time = $conn->prepare($query_time);
        $cad_time->execute();

        $query_qnt_registros = "SELECT COUNT(id) AS num_result FROM tbtime";
        $result_qnt_registros = $conn->prepare($query_qnt_registros);
        $result_qnt_registros->execute();
        $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

        if (($cad_time->rowCount()) and ($row_qnt_registros['num_result'] <= 10)) {
            echo "Time<strong> " . $dados['nomeTime'] . "</strong> cadastrado com sucesso<br>";
        } else {
            echo "Número máximo de times atingido!<br>";
        }
    }

    ?>
    <form name="cad-campeonato" method="POST" action="">

        <label>Nome do time</label><br>
        <input type="text" name="nomeTime" id="nomeTime" required><br>

        <label>Nome do jogador 1:</label><br>
        <input type="text" name="nomeJogador1" id="nomeJogador1" required><br>

        <label>Nome do jogador 2:</label><br>
        <input type="text" name="nomeJogador2" id="nomeJogador2" required><br>

        <input type="submit" name="btnCadastrar" id="btnCadastar">




    </form>
    <a href="./listarTimes.php"><button>LISTAR TIMES</button></a>
</body>

</html>