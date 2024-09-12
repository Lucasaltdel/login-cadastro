<?php 
ob_start();
if (isset($_POST['submit'])) {
    include_once('conexao.php');
    
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $nascimento = mysqli_real_escape_string($conexao, $_POST['nascimento']);
    $pais = mysqli_real_escape_string($conexao, $_POST['pais']);

    // Verificar se o email, telefone ou senha já existem
    $check_email_query = "SELECT * FROM usuarios WHERE email = '$email'";
    $check_telefone_query = "SELECT * FROM usuarios WHERE telefone = '$telefone'";
    
    $check_email_result = mysqli_query($conexao, $check_email_query);
    $check_telefone_result = mysqli_query($conexao, $check_telefone_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $error_message = "Erro: O email já está cadastrado.";
    } elseif (mysqli_num_rows($check_telefone_result) > 0) {
        $error_message = "Erro: O telefone já está cadastrado.";
    } else {
        // Inserir dados se nenhuma das verificações falhar
        $result = mysqli_query($conexao, "INSERT INTO usuarios (nome, email, senha, telefone, sexo, nascimento, pais) VALUES ('$nome', '$email', '$senha', '$telefone', '$sexo', '$nascimento', '$pais')");
        
        if ($result) {
            $success_message = "Cadastro realizado com sucesso!";
        } else {
            $error_message = "Erro ao cadastrar: " . mysqli_error($conexao);
        }
    }
    ob_end_clean();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="phpstyles.css">
</head>
<body> 
    <div class="login-container">
        <h2>Cadastro</h2>
        <form action="cadastro.php" method="post">
            <div class="input-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="input-group">
                <label for="telefone">Telefone</label>
                <input type="number" id="telefone" name="telefone" required>
            </div>
            <div class="input-group">
                <label for="sexo">Sexo</label>
                <input type="text" id="sexo" name="sexo" required>
            </div>
            <div class="input-group">
                <label for="nascimento">Nascimento</label>
                <input type="date" id="nascimento" name="nascimento" required>
            </div>
            <div class="input-group">
                <label for="pais">Pais</label>
                <input type="text" id="pais" name="pais" required>
            </div>
            <button type="submit" name="submit" class="enviar">Enviar</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>





