<?php
$mysqli = new mysqli("localhost", "root", "", "clientes");
if ($mysqli->connect_errno) {
    echo json_encode(array('error' => 'Falha ao conectar ao MySQL: ' . $mysqli->connect_error));
    exit();
}
session_start();
$idUsuario = $_SESSION['id_usuario'];
$sql = "SELECT caminho FROM imagem WHERE id_usuario = $idUsuario order by 1 desc";
$resultado = $mysqli->query($sql);
if ($resultado->num_rows > 0) {
    $caminhoImagem = $resultado->fetch_assoc()['caminho'];

    echo json_encode(array('caminhoImagem' => $caminhoImagem));
} else {
    echo json_encode(array('caminhoImagem' => 'sem_imagem'));
}
$mysqli->close();
?>
