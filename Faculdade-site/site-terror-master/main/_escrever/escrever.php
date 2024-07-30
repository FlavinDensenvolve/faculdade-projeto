<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../_login/login.html");
        exit();
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="escrever.css">
    <link href="../../utils/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../utils/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <iframe src="../navbar/navbar.php" width="100%" height="50" frameborder="0" id="navbar"></iframe>

    <div class="body-content">
        <div class="escrever-content">
        <?php
            if (isset($_GET['acao'])) {
                include '../../conexao.php';

                $acao = $_GET['acao'];

                if ($acao === 'escrever_historia') {
                    $sql = "SELECT id, descricao FROM tema";
                    $result = $conn->query($sql);
                    
                    echo "<form method='post' action='processarHistoria.php' class='story-form form-escrever-historia'>";

                    echo "<div class='form-group'>";
                    echo "<label for='autor' style='color: #555; margin-bottom: 5px;'>Autor: </label>";
                    echo "<input type='text' id='autor' name='autor' value='" . $_SESSION['nick'] . "' class='form-control' disabled style='background-color: #f0f0f0; margin-bottom: 10px; width: 70%;'>";
                    echo "</div>";

                    echo "<div class='form-group'>";
                    echo "<label for='tema' style='color: #555; margin-bottom: 5px;'>Tema:</label>";
                    echo "<select name='tema' id='tema' class='form-control' required style='width: 70%; margin-bottom: 5px;'>";
                    echo "<option value='' disabled selected>Escolha seu tema</option>";
    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                        }
                    }
                    
                    echo "</select>";
                    echo "</div>";

                    echo "<div class='form-group'>";
                    echo "<label for='titulo' style='color: #555; margin-bottom: 5px;'>Título:</label>";
                    echo "<input type='text' name='titulo' id='titulo' class='form-control' required style='width: 70%; margin-bottom: 10px;'>";
                    echo "</div>";

                    echo "<div class='form-group'>";
                    echo "<label for='descricao' style='color: #555; margin-bottom: 5px;'>Descrição:</label>";
                    echo "<textarea name='descricao' id='descricao' class='form-control' required style='width: 70%; height: 260px; margin-bottom: 10px;'></textarea>";
                    echo "</div>";

                    echo "<input type='hidden' name='acao' id='acao' value='escrever_hist'>";
                    echo "<input type='submit' 
                                 value='Salvar' 
                                 class='btn btn-primary' 
                                 style='background-color: #555; border-color: #555; width: 8%;'
                                 onclick='document.getElementById('acao').value='escrever_hist''>";
                    echo "</form>";
                }
                else if ($acao == 'escrever_lenda') {
                    echo "<form method='post' action='processarHistoria.php' class='story-form form-escrever-historia'>";

                    echo "<div class='form-group'>";
                    echo "<label for='autor' style='color: #555; margin-bottom: 5px;'>Autor: </label>";
                    echo "<input type='text' id='autor' name='autor' value='" . $_SESSION['nick'] . "' class='form-control' disabled style='background-color: #f0f0f0; margin-bottom: 10px; width: 70%;'>";
                    echo "</div>";

                    echo "<div class='form-group'>";
                    echo "<label for='pais' style='color: #555; margin-bottom: 5px;'>País:</label>";
                    echo "<input type='text' name='pais' id='pais' class='form-control' required style='width: 70%; margin-bottom: 10px;'>";
                    echo "</div>";

                    echo "<div class='form-group'>";
                    echo "<label for='titulo' style='color: #555; margin-bottom: 5px;'>Título:</label>";
                    echo "<input type='text' name='titulo' id='titulo' class='form-control' required style='width: 70%; margin-bottom: 10px;'>";
                    echo "</div>";

                    echo "<div class='form-group'>";
                    echo "<label for='descricao' style='color: #555; margin-bottom: 5px;'>Descrição:</label>";
                    echo "<textarea name='descricao' id='descricao' class='form-control' required style='width: 70%; height: 260px; margin-bottom: 10px;'></textarea>";
                    echo "</div>";

                    echo "<input type='hidden' name='acao' id='acao' value='escrever_lenda'>";
                    echo "<input type='submit' 
                                 value='Salvar' 
                                 class='btn btn-primary' 
                                 style='background-color: #555; border-color: #555; width: 8%;'
                                 onclick='document.getElementById('acao').value='escrever_lenda''>";
                    echo "</form>";
                }
                else {
                    echo "Ação Inválida";
                }
            } else {
                
            }
        ?>
        </div>
    </div>

    <script src="escrever.js"></script>
    <iframe id="footer" src="../footer/footer.html" width="100%" height="80" frameborder="0"></iframe>
</body>
</html>