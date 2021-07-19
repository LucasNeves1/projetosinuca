<?php include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleListarTimes.css" />
    <title>LISTAR TIMES</title>
</head>

<body>
    <h1 class="centralizar">LISTA DOS TIMES INSCRITOS NO CAMPEONATO</h1>
    <?php

    $query_camp = "SELECT id, nome, premiacao, pontuacao, regras FROM campeonato";
    $result_camp = $conn->prepare($query_camp);
    $result_camp->execute();

    if (($result_camp) and ($result_camp->rowCount() != 0)) {
        $row_camp = $result_camp->fetch(PDO::FETCH_ASSOC);
    }

    echo "<p class='centralizar'>Pontuação para vitória: " . $row_camp['pontuacao'] . "</p>";

    ?>
    <div class="resultados">
        <?php

        $query_times = "SELECT id, nome, jogador1, jogador2, pontuacao FROM tbtime ORDER BY pontuacao DESC";
        $result_times = $conn->prepare($query_times);
        $result_times->execute();

        if (($result_times) and ($result_times->rowCount() != 0)) {
            while ($row_time = $result_times->fetch(PDO::FETCH_ASSOC)) {
                extract($row_time);

        ?>

                <div class="time">

                    <?php
                    echo "<p class='nomeTimes'>$nome </p><br>";
                    echo "<br>ID do time: $id <br>";
                    echo "Nome do jogador 1: $jogador1<br>";
                    echo "Nome do jogador 2: $jogador2<br>";
                    echo "<strong>Pontuação do time: $pontuacao<br></strong>";
                    echo "<a href='editarTime.php?id=$id'><button class='btnAlterar'>Alterar pontuação</button></a><br>"; ?> </div>
        <?php
            }
        }

        ?>
    </div>
    <div class="centralizar"><a href="./cadastrarTimes.php"><button class="btnInscrever">INSCREVER MAIS UM TIME</button></a></div>
</body>

</html>