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

$query_camp = "SELECT id, nome, premiacao, pontuacao, regras FROM campeonato LIMIT 1";
$result_camp = $conn->prepare($query_camp);
$result_camp->execute();

if (($result_camp) and ($result_camp->rowCount() != 0)) {
    $row_camp = $result_camp->fetch(PDO::FETCH_ASSOC);
    extract($row_camp);
    $limitePontos = $pontuacao;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Editar time</title>
</head>

<body>
    <?php
    //Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Verificar se o usuário clicou no botão
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
                echo "<p style='color: green;'>Usuário editado com sucesso!</p>";
            } else {
                echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            }
        }
    }
    ?>
    <span>Nome do time: <?php echo $row_time['nome']; ?></span><br>
    <span>Nome do jogador 1: <?php echo $row_time['jogador1']; ?></span><br>
    <span>Nome do jogador 2: <?php echo $row_time['jogador2']; ?></span><br>
    <form id="edit-time" method="POST" action="">
        <label>Pontuação:</label>
        <input type="number" name="pontuacao" id="pontuacao" value="<?php
                                                                    if (isset($dados['pontuacao'])) {
                                                                        echo $dados['pontuacao'];
                                                                    } elseif (isset($row_time['pontuacao'])) {
                                                                        echo $row_time['pontuacao'];
                                                                    }
                                                                    ?>" max="<?php $limitePontos ?>"><br><br>


        <input type="submit" value="Salvar" name="editTime">
        <?php

        if (empty($dados['pontuacao'])) {
            $dados['pontuacao'] = 0;
        } else {
            $win_condition = $dados['pontuacao'];
            if ($win_condition == $limitePontos) {
                header("Location: vitoria.php?id=$id'");
            }
        }

        ?>
        <button onClick="aumentaPont();">Aumentar</button>

        <button onClick="diminuiPont();">Diminuir</button>

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

    </form>

</body>

</html>