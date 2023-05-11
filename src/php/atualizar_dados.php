<?php
$selectedItemId = $_POST['id'];
$consumo = $_POST['consumo'];
$horas = $_POST['horas'];
$quantidade = $_POST['quantidade'];

$mysqli = new mysqli("localhost", "root", "", "clientes");

if ($mysqli->connect_error) {
  die('A conexão falhou: ' . $mysqli->connect_error);
} else {
  $stmt = $mysqli->prepare("UPDATE eletro SET consumo = ?, horas = ?, quantidade = ? WHERE id = ?");
  $stmt->bind_param("sssi", $consumo, $horas, $quantidade, $selectedItemId);
  $stmt->execute();
  $stmt->close();
  $mysqli->close();
}
?>
