<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $limite = isset($_POST['limite']) ? str_replace(',', '.', $_POST['limite']) : '';

    $mysqli = new mysqli("localhost", "root", "", "clientes");

    if ($mysqli->connect_error) {
        die('A conexão falhou: ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO limite (valorprevisto) VALUES (?)");
        $stmt->bind_param("d", $limite);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('Limite previsto registrado com sucesso!');
                window.location.href = '/src/html/config.html';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao registrar o limite previsto!');
                window.location.href = '/src/html/limite.html';
            </script>";
        }

        $stmt->close();
        $mysqli->close();
    }
}
?>
