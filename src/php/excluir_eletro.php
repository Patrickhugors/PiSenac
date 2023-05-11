<?php
$selectedItemId = $_POST['id'];

$mysqli = new mysqli("localhost", "root", "", "clientes");

if ($mysqli->connect_error) {
  die('A conexão falhou: ' . $mysqli->connect_error);
} else {
  $stmt = $mysqli->prepare("DELETE FROM eletro WHERE id = ?");
  $stmt->bind_param("i", $selectedItemId);
  $stmt->execute();
  $stmt->close();
  $mysqli->close();
}
?>
