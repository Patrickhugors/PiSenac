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

    $sql = "DELETE FROM eventos WHERE id_usuario = ? AND titulo = ? AND data = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $login_ativo, $titulo, $data);

    if ($stmt->execute()) {
      $response = array("success" => true);
      echo json_encode($response);
    } else {
      $response = array("success" => false, "error" => $stmt->error);
      echo json_encode($response);
    }

    $stmt->close();
  } else {
    $response = array("success" => false, "message" => "Dados do evento ausentes.");
    echo json_encode($response);
  }
} else {
  $response = array("success" => false, "message" => "Requisição inválida.");
  echo json_encode($response);
}

$conn->close();
?>
