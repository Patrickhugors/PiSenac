<?php
 session_start(); 
 $login_ativo = $_SESSION['id_usuario'];
 $senha_atual = $_POST['senha_atual'];
 $nova_senha = $_POST['nova_senha'];
 
 $mysqli = new mysqli("localhost", "root", "", "clientes");
 
 if ($mysqli->connect_error) {
     die('A conexão falhou: ' . $mysqli->connect_error);
 } else {
     $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE id = ? AND senha = ?");
     $stmt->bind_param("ss", $login_ativo, $senha_atual); 
     $stmt->execute();
     $stmt_result = $stmt->get_result();
 
     if ($stmt_result->num_rows > 0) {
         $stmt = $mysqli->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
         $stmt->bind_param("ss", $nova_senha, $login_ativo); 
         $stmt->execute();
 
         if ($stmt->affected_rows > 0) {
             echo "<script>
                 alert('Senha atualizada com sucesso!');
                 window.location.href = '/src/html/config.html';
             </script>";
         } else {
             echo "<script>
                 alert('Erro ao atualizar a senha!');
                 window.location.href = '/src/html/senha.html';
             </script>";
         }
     } else {
         echo "<script>
             alert('Senha atual incorreta!');
             window.location.href = '/src/html/senha.html';
         </script>";
     }
 
     $stmt->close();
     $mysqli->close();
 }
 
?>
