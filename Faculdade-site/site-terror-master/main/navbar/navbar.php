<html>
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="navbar.css">
</head>
<body>
    <div class="navbar">
        <div class="links-content">
            <img src="../../assets/logo design.jpg" alt="logo site">
            <a href="../home/home.html" target="_top">Home</a>
            <a href="../_historias/historias.php" target="_top">Histórias</a>
            <a href="../_lendas/lendas.php" target="_top">Lendas</a>
            <a href="../_sobre/sobre.html" target="_top">Sobre</a>
        </div>
        <div class="login-content">
            <?php
                session_start();

                if (!isset($_SESSION['user_id'])) {
                    echo "<a href='../_login/login.html' target='_top'>Login</a>";
                }
                else {
                    include '../../conexao.php';

                    // Preparando a consulta para evitar SQL Injection
                    $stmt = $conn->prepare("SELECT Nick FROM usuario WHERE Id = ?");
                    $stmt->bind_param("i", $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<a href='../_login/logout.php' target='_top'>" . htmlspecialchars($row["Nick"]) . "</a>";
                    } else {
                        echo "Usuário não encontrado.";
                    }

                    $stmt->close();
                    $conn->close();
                }
            ?>
        </div>
    </div>
</body>
</html>