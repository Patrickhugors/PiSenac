<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "Você precisa estar logado para acessar esta página.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_SESSION['id_usuario'];

    $mysqli = new mysqli("localhost", "root", "", "clientes");

    if ($mysqli->connect_error) {
        die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
    }

    $consulta = $mysqli->prepare("DELETE FROM contas WHERE id_usuario = ?");

    if (!$consulta) {
        die("Erro na preparação da consulta: " . $mysqli->
        error);
    }
    $consulta->bind_param("s", $idUsuario);

if ($consulta->execute()) {
    echo '<script>alert("Contas removidas com sucesso!"); window.location.href="/src/html/config.html";</script>';
} else {
    echo '<script>alert("Ocorreu um erro ao remover as contas."); window.location.href="/src/html/config.html";</script>';
}

$consulta->close();
$mysqli->close();
}
?>