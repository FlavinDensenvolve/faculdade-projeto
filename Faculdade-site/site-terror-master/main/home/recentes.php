<?php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "rota_terror";

// Conecte-se ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter os títulos das histórias mais recentes
$sql = "SELECT Titulo FROM historia ORDER BY Data_Created DESC LIMIT 5";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output dos títulos das histórias em divs
    while($row = $result->fetch_assoc()) {
        echo "<div class='historia-item'>";
        echo "<p>" . $row["Titulo"] . "</p>";
        echo "</div>";
    }
} else {
    echo "Nenhuma história encontrada.";
}
$conn->close();
?>
