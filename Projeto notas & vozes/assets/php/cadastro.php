<?php
// conexão
$conn = new mysqli("localhost", "root", "", "notas_vozes");

if ($conn->connect_error) {
  die("Erro na conexão");
}

// recebe os dados do form
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$curso = $_POST['curso'];
$dias = $_POST['dias'];
$horarios = $_POST['horarios'];
$telefone = $_POST['telefone'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// salva no banco
$sql = "INSERT INTO usuarios (nome, idade, curso, dias, horarios, telefone, senha)
        VALUES (?, ?, ?, ?, ?, ? ,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssss", $nome, $idade, $curso, $dias, $horarios, $telefone, $senha);
$stmt->execute();

echo "Cadastro realizado com sucesso!";
