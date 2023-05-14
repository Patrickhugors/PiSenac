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

// Mapear os números dos meses aos nomes dos meses em português
$meses = array(
    1 => "Janeiro",
    2 => "Fevereiro",
    3 => "Março",
    4 => "Abril",
    5 => "Maio",
    6 => "Junho",
    7 => "Julho",
    8 => "Agosto",
    9 => "Setembro",
    10 => "Outubro",
    11 => "Novembro",
    12 => "Dezembro"
);

// Consultar as contas do banco de dados e ordená-las pelo valor do mês
$stmt = $conn->prepare("SELECT mes, valor FROM contas WHERE id_usuario = ? ORDER BY mes");
$stmt->bind_param("i", $login_ativo);
$stmt->execute();
$result = $stmt->get_result();

$contas = array();
while ($row = $result->fetch_assoc()) {
    $mes = $meses[$row['mes']];
    $contas[] = $mes . " - R$" . $row['valor'];
}

$response = array(
    'success' => true,
    'contas' => $contas
);

// Retornar as contas como JSON
header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
