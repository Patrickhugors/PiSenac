<?php
    session_start();
    $login_ativo = $_SESSION['id_usuario'];
    $nome = $_POST['nome'];
    $consumo = $_POST['consumo'];
    $horas = $_POST['horas'];
    $quantidade = $_POST['quantidade'];

    $mysqli = new mysqli("localhost", "root", "", "clientes");

    if ($mysqli->connect_error) {
        die('A conexao falhou : ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO eletro (nome, consumo, horas, quantidade, id_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $nome, $consumo, $horas, $quantidade, $login_ativo);
        $stmt->execute();
        echo "<script>
            alert('Produto adicionado com sucesso');
            window.location.href = '/src/html/novo.html';
        </script>";
        $stmt->close();
        $mysqli->close();
    }
?>