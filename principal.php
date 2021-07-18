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
    <link rel="stylesheet" type="text/css" href="./estilos/stylePrincipal.css" />
    <title>CAMPEONATO DE SINUCA</title>
</head>

<body>

    <?php
    $query_campeonato = "SELECT id, nome, premiacao, pontuacao, regras FROM campeonato";
    $result_campeonato = $conn->prepare($query_campeonato);
    $result_campeonato->execute();

    if (($result_campeonato) and ($result_campeonato->rowCount() != 0)) {
        $row_camp = $result_campeonato->fetch(PDO::FETCH_ASSOC);
        extract($row_camp);
        echo "<h1 style='text-transform:uppercase'><center> $nome </center></h1>";
    } else {
        echo "Você ainda não cadastrou seu campeonato!";
    }

    ?>
    <div class="dadosCampeonato">

        <span>ID do campeonato: <?php echo "" . $row_camp['id'] ?><br>
            <span>Premiação do campeonato: <?php echo "" . $row_camp['premiacao'] ?><br>
                <span>Pontuação para vitória: <?php echo "" . $row_camp['pontuacao'] ?><br>
                    <span>Regras: <?php echo "" . $row_camp['regras'] ?><br>

    </div>
    <div class="btnsLista">
        <?php
        echo "<a href='./cadastrarTimes.php'><button class='btnIniciar'>INICIAR CAMPEONATO</button></a>";
        echo "<a href='./editarCamp.php?id=$id'><button class='btnEditar'>EDITAR REGRAS</button></a>";
        echo "<a href='./apagarTimes.php'><button class='btnRemover'>DELETAR CAMPEONATO</button></a>";
        ?>
    </div>

</body>

</html>