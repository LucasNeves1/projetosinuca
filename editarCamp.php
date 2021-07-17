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
    var_dump($row_camp);
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
    <title>EDITAR CAMPEONATO</title>
</head>

<body>
    <?php
    //Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Verificar se o usuário clicou no botão
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
                echo "<p style='color: green;'>Usuário editado com sucesso!</p>";
            } else {
                echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            }
        }
    }
    ?>
    <form id="edit-time" method="POST" action="">
        <label>Nome do campeonato:</label>
        <input type="text" name="nome" id="nome" value="<?php
                                                        if (isset($dados['nome'])) {
                                                            echo $dados['nome'];
                                                        } elseif (isset($row_camp['nome'])) {
                                                            echo $row_camp['nome'];
                                                        }
                                                        ?>"><br><br>
        <label>Premiação:</label>
        <input type="text" name="premiacao" id="premiacao" value="<?php
                                                                    if (isset($dados['premiacao'])) {
                                                                        echo $dados['premiacao'];
                                                                    } elseif (isset($row_camp['premiacao'])) {
                                                                        echo $row_camp['premiacao'];
                                                                    }
                                                                    ?>"><br><br>
        <label>Pontuação: </label>
        <input type="number" name="pontuacao" id="pontuacao" value="<?php
                                                                    if (isset($dados['pontuacao'])) {
                                                                        echo $dados['pontuacao'];
                                                                    } elseif (isset($row_camp['pontuacao'])) {
                                                                        echo $row_camp['pontuacao'];
                                                                    }
                                                                    ?>"><br><br>
        <label>Regras:</label>
        <input type="textarea" name="regras" id="regras" value="<?php
                                                                if (isset($dados['regras'])) {
                                                                    echo $dados['regras'];
                                                                } elseif (isset($row_camp['regras'])) {
                                                                    echo $row_camp['regras'];
                                                                }
                                                                ?>"><br><br>


        <input type="submit" value="Salvar" name="editCamp">

    </form>
</body>

</html>