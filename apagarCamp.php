<?php

include_once './conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$query_camp = "SELECT id FROM campeonato WHERE id = $id";
$result_camp = $conn->prepare($query_camp);
$result_camp->execute();

if (($result_camp) and ($result_camp->rowCount() != 0)) {
    $query_del_camp = "DELETE FROM campeonato WHERE id = $id";
    $apagar_camp = $conn->prepare($query_del_camp);


    if ($apagar_camp->execute()) {
        $query_times = "SELECT * FROM tbtime";
        $result_times = $conn->prepare($query_times);
        $result_times->execute();

        if (($result_times) and ($result_times->rowCount() != 0)) {
            $query_del_times = "DELETE FROM tbtime";
            $apagar_times = $conn->prepare($query_del_times);
            header("Location: ./index.php ");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleApagar.css" />
    <title>FIM DE CAMPEONATO</title>
</head>

<body>
</body>

</html>