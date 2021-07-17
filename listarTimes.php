<?php include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>LISTAR TIMES</title>
</head>

<body>
    <div class="header">LISTA DOS TIMES INSCRITOS NO CAMPEONATO</div>
    <div class="resultados">
        <?php

        $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

        // $limite_resultado = 2;

        // $inicio = ($limite_resultado * $pagina) - $limite_resultado;

        $query_times = "SELECT id, nome, jogador1, jogador2, pontuacao FROM tbtime";
        $result_times = $conn->prepare($query_times);
        $result_times->execute();

        if (($result_times) and ($result_times->rowCount() != 0)) {
            while ($row_time = $result_times->fetch(PDO::FETCH_ASSOC)) {
                extract($row_time);
        ?><div class="time">

                    <?php
                    echo "<br>ID do time: $id <br>";
                    echo "Nome do time: $nome <br>";
                    echo "Nome do jogador 1: $jogador1<br>";
                    echo "Nome do jogador 2: $jogador2<br>";
                    echo "<strong>Pontuação do time: $pontuacao<br></strong>";
                    echo "<a href='editarTime.php?id=$id'><button>Alterar pontuação</button></a><br>"; ?> </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>