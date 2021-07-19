<?php

include_once './conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}

$query_camp = "SELECT id, nome, premiacao, pontuacao, regras FROM campeonato WHERE id = $id LIMIT 1";
$result_camp = $conn->prepare($query_camp);
$result_camp->execute();

if (($result_camp) and ($result_camp->rowCount() != 0)) {
    $row_camp = $result_camp->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" type="text/css" href="./estilos/styleEditar.css" />
    <title>EDITAR CAMPEONATO</title>
</head>

<body>
    <?php

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['editCamp'])) {
        $empty_input = false;
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
        }
        if (!$empty_input) {
            $query_up_time = "UPDATE campeonato SET nome =:nome, premiacao=:premiacao, pontuacao=:pontuacao, regras=:regras WHERE id=:id";
            $edit_time = $conn->prepare($query_up_time);
            $edit_time->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $edit_time->bindParam(':premiacao', $dados['premiacao'], PDO::PARAM_STR);
            $edit_time->bindParam(':pontuacao', $dados['pontuacao'], PDO::PARAM_INT);
            $edit_time->bindParam(':regras', $dados['regras'], PDO::PARAM_STR);
            $edit_time->bindParam(':id', $id, PDO::PARAM_INT);
            if ($edit_time->execute()) {
                echo "<center><p style='color: green;'>Campeonato editado com sucesso!</p></center>";
            } else {
                echo "<p style='color: #f00;'>Erro: Campeonato não editado com sucesso!</p>";
            }
        }
    }
    ?>
    <form id="edit-time" method="POST" action="">
        <label class="centralizar">Nome do campeonato:</label>
        <div class="formEditar">
            <input type="text" name="nome" id="nome" class="labelFormEditar" value="<?php
                                                                                    if (isset($dados['nome'])) {
                                                                                        echo $dados['nome'];
                                                                                    } elseif (isset($row_camp['nome'])) {
                                                                                        echo $row_camp['nome'];
                                                                                    }
                                                                                    ?>"><br><br>
        </div>
        <label class="centralizar">Premiação:</label>
        <div class="formEditar">
            <input type="text" name="premiacao" id="premiacao" class="labelFormEditar" value="<?php
                                                                                                if (isset($dados['premiacao'])) {
                                                                                                    echo $dados['premiacao'];
                                                                                                } elseif (isset($row_camp['premiacao'])) {
                                                                                                    echo $row_camp['premiacao'];
                                                                                                }
                                                                                                ?>"><br><br>
        </div>
        <label class="centralizar">Pontuação: </label>
        <div class="formEditar">
            <input type="number" name="pontuacao" id="pontuacao" class="labelFormEditar" value="<?php
                                                                                                if (isset($dados['pontuacao'])) {
                                                                                                    echo $dados['pontuacao'];
                                                                                                } elseif (isset($row_camp['pontuacao'])) {
                                                                                                    echo $row_camp['pontuacao'];
                                                                                                }
                                                                                                ?>"><br><br>
        </div>
        <label class="centralizar">Regras:</label>
        <div class="formEditar">
            <input type="textarea" name="regras" id="regras" class="labelFormRegras" value="<?php
                                                                                            if (isset($dados['regras'])) {
                                                                                                echo $dados['regras'];
                                                                                            } elseif (isset($row_camp['regras'])) {
                                                                                                echo $row_camp['regras'];
                                                                                            }
                                                                                            ?>"><br><br>
        </div>

        <div class="centralizar">
            <input type="submit" value="Salvar" name="editCamp" class="btnCadastrar">
        </div>

    </form>
    <div class="centralizar"><a href="./principal.php"><button class="voltar">VOLTAR</button></a></div>
</body>

</html>