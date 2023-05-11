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

// Consultar os eventos do banco de dados
$stmt = $conn->prepare("SELECT titulo, data FROM eventos WHERE id_usuario = ?");
$stmt->bind_param("i", $login_ativo);
$stmt->execute();
$result = $stmt->get_result();

$eventos = array();
while ($row = $result->fetch_assoc()) {
  $eventos[] = array(
    'title' => $row['titulo'],
    'start' => $row['data']
  );
}

$response = array(
  'success' => true,
  'eventos' => $eventos
);

// Retornar os eventos como JSON
header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
