
<?php
session_start();
$login_ativo = $_SESSION['id_usuario'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clientes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['titulo']) && isset($_POST['data'])) {
    $titulo = $_POST['titulo'];
    $data = $_POST['data'];

    $sql = "INSERT INTO eventos (id_usuario, titulo, data) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $login_ativo, $titulo, $data);

    if ($stmt->execute()) {
      echo "Evento salvo com sucesso.";
    } else {
      echo "Erro ao salvar o evento: " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "Dados do evento ausentes.";
  }
} else {
  echo "Requisição inválida.";
}

$conn->close();
?>