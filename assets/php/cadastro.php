<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "notas_vozes");
if ($conn->connect_error) {
  echo "erro";
  exit;
}

$nome = $_POST['nome'] ?? '';
$idade = intval($_POST['idade'] ?? 0);
$curso = $_POST['curso'] ?? '';
$dias = $_POST['dias'] ?? '';
$horarios = $_POST['horarios'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$senhaOriginal = $_POST['senha'] ?? '';

if ($idade < 6 || $idade > 120) {
  echo "idade_invalida";
  exit;
}

$regex = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/';
if (!preg_match($regex, $senhaOriginal)) {
  echo "senha_invalida";
  exit;
}

$senha = password_hash($senhaOriginal, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios 
(nome, idade, curso, dias, horarios, telefone, senha)
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssss", $nome, $idade, $curso, $dias, $horarios, $telefone, $senha);

echo $stmt->execute() ? "sucesso" : "erro";
