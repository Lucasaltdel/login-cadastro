<?php
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Supondo que a conexão com o banco de dados esteja feita e disponível em $conexao
    
    // Obter dados do formulário
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    
    // Verifica se o usuário existe no banco de dados
    $query = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $id, $nome, $hash_senha);
        mysqli_stmt_fetch($stmt);

        // Verifica se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $hash_senha)) {
            // Senha correta, iniciar sessão
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nome;
            
            // Redireciona para a página de boas-vindas ou painel de controle
            header("Location: dashboard.php");
            exit;
        } else {
            // Senha incorreta
            $erro = "Email ou senha incorretos!";
        }
    } else {
        // Usuário não encontrado
        $erro = "Email ou senha incorretos!";
    }

    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="phpstyles.css">
</head>
<body> 
<div class="login-container">
        <h2>Login</h2>
        <form action="" method="post"></form>
            <div class="input-group">
                <label for="username">Usuário</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="username">email</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>


            <button type="submit">Entrar</button> 
            </br> </br>
    
            <button type="submit"><a href="cadastro.php"> criar login </a></button>
        </form>
        <p id="message"></p>
    </div>

</body>
</html>
