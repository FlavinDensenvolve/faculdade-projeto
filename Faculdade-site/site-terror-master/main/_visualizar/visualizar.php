<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="visualizar.css">
    <link href="../../utils/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../utils/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <iframe src="../navbar/navbar.php" width="100%" height="50" frameborder="0" id="navbar"></iframe>

    <div class="body-content">
    <div class="table-content">
        <?php
        include '../../conexao.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $stmt = $conn->prepare("SELECT h.Titulo, h.Descricao, u.Nick AS Autor, h.Data_Created
                        FROM historia h
                        JOIN usuario u ON h.UsuarioId = u.Id
                        WHERE h.Id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $dataCreated = $row['Data_Created'];
                $dataFormatada = date("d/m/Y", strtotime($dataCreated));

                echo "<div class='header-content'>";
                echo "<span><strong>Autor:</strong> " . $row['Autor'] ."</span>";
                echo "<span><strong>Data de Criação:</strong> "  . $dataFormatada . "</span>";
                echo "</div>";

                echo "<div class='titulo-content'>";
                echo "<h1>" . $row['Titulo'] . "</h1>";
                echo "</div>";

                echo "<div class='descricao-content'>";
                echo "<span>" . $row['Descricao'] . "</span>";
                echo "</div>";
            } else {
                echo "História não encontrada.";
            }

            $stmt->close();
        }
        else {
            echo "ID de história não fornecido.";
        }
        ?>
    </div>
</div>

    <iframe id="footer" src="../footer/footer.html" width="100%" height="80" frameborder="0"></iframe>
</body>
</html>