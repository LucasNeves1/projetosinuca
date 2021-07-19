<?php

include_once './conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}

$query_time = "SELECT id, nome, jogador1, jogador2, pontuacao FROM tbtime WHERE id = $id LIMIT 1";
$result_time = $conn->prepare($query_time);
$result_time->execute();

if (($result_time) and ($result_time->rowCount() != 0)) {
    $row_time = $result_time->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_time);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./estilos/styleEditarTimes.css" />
    <title>ALTERAR PONTUAÇÃO</title>
</head>

<body>
    <?php

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['editTime'])) {
        $empty_input = false;
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
        }
        if (!$empty_input) {
            $query_up_time = "UPDATE tbtime SET pontuacao=:pontuacao WHERE id=:id";
            $edit_time = $conn->prepare($query_up_time);
            $edit_time->bindParam(':pontuacao', $dados['pontuacao'], PDO::PARAM_INT);
            $edit_time->bindParam(':id', $id, PDO::PARAM_INT);
            if ($edit_time->execute()) {
                echo "<center><p style='color: green;'>Pontuação alterada!</p></center>";
            } else {
                echo "<center><p style='color: #f00;'>Pontuação não alterada!</p></center>";
            }
        }
    }
    ?>
    <h1 class="centralizar"><?php echo $row_time['nome']; ?></h1><br>
    <span class="centralizar">Nome do jogador 1: <br><?php echo $row_time['jogador1']; ?></span><br>
    <span class="centralizar">Nome do jogador 2: <br><?php echo $row_time['jogador2']; ?></span><br>
    <form id="edit-time" method="POST" action="">
        <label class="centralizar">Pontuação:</label>
        <div class="centralizar"><input type="number" name="pontuacao" id="pontuacao" class="inputPont" value="<?php
                                                                                                                if (isset($dados['pontuacao'])) {
                                                                                                                    echo $dados['pontuacao'];
                                                                                                                } elseif (isset($row_time['pontuacao'])) {
                                                                                                                    echo $row_time['pontuacao'];
                                                                                                                }
                                                                                                                ?>"><br><br></div>

        <div class="centralizar">
            <button onClick="aumentaPont();" class="btnAumentar">+</button>

            <button onClick="diminuiPont();" class="btnDiminuir">-</button>
        </div>
        <div class="centralizar"><input type="submit" value="Salvar" name="editTime" class="btnSalvar"></div>
        <?php

        $query_camp = "SELECT id, nome, premiacao, pontuacao, regras FROM campeonato LIMIT 1";
        $result_camp = $conn->prepare($query_camp);
        $result_camp->execute();

        if (($result_camp) and ($result_camp->rowCount() != 0)) {
            $row_camp = $result_camp->fetch(PDO::FETCH_ASSOC);
            extract($row_camp);
            $limitePontos = $pontuacao;
        }

        if (empty($dados['pontuacao'])) {
            $dados['pontuacao'] = 0;
        } else {
            $win_condition = $dados['pontuacao'];
            if ($win_condition == $limitePontos) {
                header("Location: vitoria.php?id=$id");
            }
        }

        ?>


    </form>
    <div class="centralizar"><a href="./listarTimes.php"><button class="voltar">VOLTAR PARA TABELA DE TIMES</button></a></div>
    <script>
        function aumentaPont() {

            var campo = document.getElementById("pontuacao")

            campo.value = parseInt(campo.value) + 1;

        }

        function diminuiPont() {

            var campo = document.getElementById("pontuacao")

            campo.value = parseInt(campo.value) - 1;

        }
    </script>
</body>

</html>