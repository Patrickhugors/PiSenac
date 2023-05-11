<?php
$selectedItemId = $_POST['id'];

$mysqli = new mysqli("localhost", "root", "", "clientes");

if ($mysqli->connect_error) {
  die('A conexão falhou: ' . $mysqli->connect_error);
} else {
  $stmt = $mysqli->prepare("SELECT consumo, horas, quantidade FROM eletro WHERE id = ?");
  $stmt->bind_param("i", $selectedItemId);
  $stmt->execute();
  $stmt->bind_result($consumo, $horas, $quantidade);
  $stmt->fetch();

  $dados = array(
    'consumo' => $consumo,
    'horas' => $horas,
    'quantidade' => $quantidade
  );

  echo json_encode($dados);

  $stmt->close();
  $mysqli->close();
}
?>
