<?php
    include '../../conexao.php';

    $acao = $_POST['acao'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $data_registro = date('Y-m-d H:i:s');

    if ($acao == 'login') {
        if (!empty($email) && !empty($senha)) {
            $stmt = $conn->prepare("SELECT id, senha, nick FROM usuario WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $senha_criptografada = $row["senha"];
                
                if (password_verify($senha, $senha_criptografada)) {
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['nick'] = $row['nick'];
    
                    header("Location: ../../main/home/home.html");
                    exit();
                }
                else {
                    header("Location: login.html");
                    exit();
                }
            } else {
                echo "Email não encontrado.";
            }

            $stmt->close();
        }
    }
    else if ($acao == 'registrar') {
        $nick = $_POST['nick'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];

        if (!empty($nick) && !empty($nome) && !empty($sobrenome) && !empty($email) && !empty($senha)) {
            $sql = "SELECT Id FROM hierarquia WHERE Descricao = 'Usuario'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hierarquiaId = $row["Id"];

                $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
    
                $stmt = $conn->prepare("INSERT INTO usuario (nick, nome, sobrenome, email, senha, hierarquiaId, Data_Created) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssis", $nick, $nome, $sobrenome, $email, $senha_criptografada, $hierarquiaId, $data_registro);
        
                if ($stmt->execute()) {
                    header("Location: login.html");
                    exit();
                } else {
                    echo "Erro: " . $stmt->error;
                }
        
                $stmt->close();
            }
            else {
                echo "Hierarquia inválida";
            }
            
        } else {
            echo "Por favor, preencha todos os campos.";
        }
    }
    else {
        echo "Ação inválida";
    }

    mysqli_close($conn);
?>