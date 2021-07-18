<?php

include_once './conexao.php';

$query_times = "DELETE FROM tbtime";
$result_times = $conn->prepare($query_times);
$result_times->execute();

$query_camps = "DELETE FROM campeonato";
$result_camps = $conn->prepare($query_camps);
$result_camps->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleApagar.css" />
    <title>CAMPEONATO FINALIZADO</title>
</head>

<body>
    <h1 class="centralizar">CAMPEONATO ENCERRADO!</h1>
    <div class="centralizar"><a href="./index.php"><button class="novo">NOVO CAMPEONATO</button></a></div>
</body>

</html>