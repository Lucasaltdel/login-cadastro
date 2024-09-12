
<?php 
$dbhost = 'localhost';
$dbusername = 'root';
$dbpassword = '';  // Use a senha correta
$dbname = 'cadastro';

$conexao = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
ob_start();
if($conexao->connect_errno){
    echo "Erro: " . $conexao->connect_error;
    exit();
} else {
    echo "Conectado com sucesso";
}
ob_end_clean();

?>


