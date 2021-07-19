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
    <title>VISUALIZAR CAMPEONATO</title>
</head>

<body>

    <?php

    $query_time = "SELECT id, nome, jogador1, jogador2, pontuacao FROM tbtime WHERE id = $id";
    $result_time = $conn->prepare($query_time);
    $result_time->execute();

    if (($result_time) and ($result_time->rowCount() != 0)) {
        $row_time = $result_time->fetch(PDO::FETCH_ASSOC);
        extract($row_time);
        echo "<br>ID do time: $id <br>";
        echo "Nome do time: $nome <br>";
        echo "Nome do jogador 1: $jogador1<br>";
        echo "Nome do jogador 2: $jogador2<br>";
        echo "Pontuação do time: $pontuacao<br>";
    }

    ?>

</body>

</html>