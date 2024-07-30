<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../_login/login.html");
        exit();
    }

    include '../../conexao.php';

    $acao = $_POST['acao'];
    $autorId = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_registro = date('Y-m-d H:i:s');

    if ($acao == 'escrever_hist') {
        $temaId = $_POST['tema'];

        if (!empty($temaId) && !empty($titulo) && !empty($descricao)) {
            $stmt = $conn->prepare("INSERT INTO historia (Titulo, Descricao, TemaId, UsuarioId, Data_Created) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiis", $titulo, $descricao, $temaId, $autorId, $data_registro);

            if ($stmt->execute()) {
                header("Location: ../_historias/historias.php");
                exit();
            } else {
                echo "Erro: " . $stmt->error;
            }
    
            $stmt->close();
        }
        else {
            echo "Por favor, preencha todos os campos.";
        }
    }
    else if ($acao == 'escrever_lenda') {
        $pais = $_POST['pais'];

        if (!empty($pais) && !empty($titulo) && !empty($descricao) && !empty($autorId)) { 
            $stmt = $conn->prepare("INSERT INTO lenda (Pais, Data_Created) VALUES (?, ?)");
            $stmt->bind_param("ss", $pais, $data_registro);

            if ($stmt->execute()) {
                $lendaId = $conn->insert_id;

                $stmt = $conn->prepare("INSERT INTO historia (Titulo, Descricao, LendaId, UsuarioId, Data_Created) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssiis", $titulo, $descricao, $lendaId, $autorId, $data_registro);

                if ($stmt->execute()) {
                    header("Location: ../_lendas/lendas.php");
                    exit();
                }
                else {
                    echo "Erro ao inserir historia";
                }
            }
            else {
                echo "Erro ao inserir lenda";
            }
        }
        else {
            echo "Dados insuficientes fornecidos.";
        }
    }
    else {
        echo "Ação Inválida";
    }


?>