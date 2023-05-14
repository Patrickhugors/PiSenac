<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $mysqli = new mysqli("localhost", "root", "", "clientes");
        if ($mysqli->connect_errno) {
            die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
        }
        session_start();
        $idUsuario = $_SESSION['id_usuario'];
        $nomeArquivo = $_FILES['imagem']['name'];
        $tipoArquivo = $_FILES['imagem']['type'];
        $caminhoArquivo = "../assets/images/FotosUsuarios/" . $nomeArquivo;

        // Verificar se o usuário já possui uma imagem
        $sqlVerificar = "SELECT id_usuario FROM imagem WHERE id_usuario = $idUsuario";
        $resultado = $mysqli->query($sqlVerificar);

        if ($resultado->num_rows > 0) {
            // Se o usuário já possui uma imagem, fazer o update
            $sql = "UPDATE imagem SET nome = '$nomeArquivo', tipo = '$tipoArquivo', caminho = '$caminhoArquivo' WHERE id_usuario = $idUsuario";
        } else {
            // Se o usuário não possui uma imagem, fazer o insert
            $sql = "INSERT INTO imagem (nome, tipo, caminho, id_usuario) VALUES ('$nomeArquivo', '$tipoArquivo', '$caminhoArquivo', '$idUsuario')";
        }

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoArquivo)) {
            if ($mysqli->query($sql) === true) {
                echo '<script>alert("Imagem enviada com sucesso!"); window.location.href="/src/html/perfil.html";</script>';
            } else {
                echo '<script>alert("Erro ao inserir ou atualizar os detalhes da imagem no banco de dados: ' . $mysqli->error . '");</script>';
            }
        } else {
            echo '<script>alert("Erro ao mover o arquivo para o diretório desejado.");</script>';
        }
        $mysqli->close();
    } else {
        echo '<script>alert("Nenhum arquivo foi enviado ou ocorreu um erro durante o upload.");</script>';
    }
}
?>
