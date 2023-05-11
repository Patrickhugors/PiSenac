<?php
    session_start();
    $valor = isset($_POST['tarifa']) ? str_replace(',', '.', $_POST['tarifa']) : '';
    $companhia = isset($_POST['companhia']) ? $_POST['companhia'] : '';

    $mysqli = new mysqli("localhost", "root", "", "clientes");

    if ($mysqli->connect_error) {
        die('A conexão falhou: ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO tarifa (valor, companhia) VALUES (?, ?)");
        $stmt->bind_param("ds", $valor, $companhia);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('Tarifa registrada com sucesso!');
                window.location.href = '/src/html/config.html';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao registrar tarifa!');
                window.location.href = '/src/html/tarifa.html';
            </script>";
        }

        $stmt->close();
        $mysqli->close();
    }
?>