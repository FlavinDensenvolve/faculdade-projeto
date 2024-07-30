<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Tektur&display=swap" rel="stylesheet">
    <link href="../../utils/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../utils/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <link rel="stylesheet" href="lendas.css">
    <title>LENDAS</title>
</head>
<body>
    <iframe src="../navbar/navbar.php" width="100%" height="50" frameborder="0" id="navbar"></iframe>

    <div class="body-content">
        <div class="table-content">
            <?php
            
                include '../../conexao.php';

                $itemsPerPage = 9; 
                $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                $offset = ($page - 1) * $itemsPerPage;

                $sql = "
                SELECT h.Id, h.Titulo, u.Nick, h.LendaId, l.Pais 
                FROM historia h
                JOIN lenda l ON h.LendaId = l.id
                JOIN usuario u ON h.UsuarioId = u.id
                LIMIT $offset, $itemsPerPage
                ";
                $result = $conn->query($sql);

                echo "<div class='btn-content'>";
                echo "<a href='../_escrever/escrever.php?acao=escrever_lenda'>+</a>";
                echo "</div>";

                if ($result->num_rows > 0) {
                    echo "<div class='card-content'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='pais' data-id='" . $row["Id"] . "'>";
                        echo "<div class='top_paises'>";
                        echo "<h3>" . $row["Pais"] . "</h3>";
                        echo "</div>";
                        echo "<span>" . $row['Titulo']. "</span>";
                        echo "</div>";
                    }
                    echo "</div>";

                    $sql = "SELECT COUNT(*) AS total FROM historia WHERE LendaId IS NOT NULL";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $totalPages = ceil($row['total'] / $itemsPerPage);

                    echo "<div class='pagination'>";
                    if ($page > 1) {
                        echo "<a href='?page=".($page - 1)."'>Anterior</a>";
                    }
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                    if ($page < $totalPages) {
                        echo "<a href='?page=".($page + 1)."'>Próximo</a>";
                    }
                    echo "</div>";
                }
                else {
                    echo "Nenhuma história encontrada.";
                }

                mysqli_close($conn);
            ?>
        </div>
    </div>

    <script>
            document.addEventListener("DOMContentLoaded", function() {
                var cards = document.querySelectorAll('.pais');
                cards.forEach(function(card) {
                    card.addEventListener('click', function() {
                        var id = this.getAttribute('data-id');
                        window.location.href = '../_visualizar/visualizar.php?id=' + id;
                    });
                });
            });
        </script>
    
    <iframe id="footer" src="../footer/footer.html" width="100%" height="80" frameborder="0"></iframe>
</body>
</html>
