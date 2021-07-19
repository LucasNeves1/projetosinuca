<?php

include_once './conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleVitoria.css" />
    <title>FIM DE CAMPEONATO</title>
</head>

<body>

    <?php

    $query_times = "SELECT id, nome, jogador1, jogador2, pontuacao FROM tbtime";
    $result_times = $conn->prepare($query_times);
    $result_times->execute();

    if (($result_times) and ($result_times->rowCount() != 0)) {
        $row_time = $result_times->fetch(PDO::FETCH_ASSOC);
        extract($row_time);
    }

    ?>
    <div class="msgCampeao">CAMPEÕES!!!</div>
    <div class="centralizar"><img src="./estilos/campeao.png" width="300px" height="300px"></div>
    <h1 class="centralizar">PARABÉNS AO TIME: <?php echo $nome ?></h1><br>
    <div class="centralizar">NOME DO JOGADOR 1: <?php echo $jogador1 ?></div><br>
    <div class="centralizar"> NOME DO JOGADOR 1: <?php echo $jogador2 ?></div><br>
    <?php echo "<div class='centralizar'><a href='./apagarTimes.php'><button class='btnIniciarCamp'>INICIAR NOVO CAMPEONATO</button></a></div>"; ?>
</body>

</html>