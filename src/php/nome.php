<?php
session_start();
$login_ativo = $_SESSION['id_usuario'];
$novo_nome = $_POST['novo_nome'];
$senha = $_POST['senha'];

$mysqli = new mysqli("localhost", "root", "", "clientes");

if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
} else {
    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE id = ? AND senha = ?");
    $stmt->bind_param("ss", $login_ativo, $senha);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        $stmt = $mysqli->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
        $stmt->bind_param("ss", $novo_nome, $login_ativo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('nome atualizado com sucesso!');
                window.location.href = '/src/html/config.html';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao atualizar o nome!');
                window.location.href = '/src/html/nome.html';
            </script>";
        }
    } else {
        echo "<script>
            alert('Senha incorreta!');
            window.location.href = '/src/html/nome.html';
        </script>";
    }

    $stmt->close();
    $mysqli->close();
}
?>
