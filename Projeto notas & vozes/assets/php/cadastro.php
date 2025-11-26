<?php
// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Função para limpar os dados
    function limpar($dado) {
        return htmlspecialchars(trim($dado));
    }

    // Captura e limpa os dados
    $nome      = limpar($_POST["nome"] ?? '');
    $idade     = intval($_POST["idade"] ?? 0);
    $curso     = limpar($_POST["curso"] ?? '');
    $nivel     = limpar($_POST["nivel"] ?? '');
    $horarios  = limpar($_POST["horarios"] ?? '');
    $email     = limpar($_POST["email"] ?? '');
    $telefone  = limpar($_POST["telefone"] ?? '');

    // Validação básica
    $erros = [];

    if (empty($nome)) {
        $erros[] = "O nome é obrigatório.";
    }

    if ($idade < 5 || $idade > 100) {
        $erros[] = "A idade deve estar entre 5 e 100 anos.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }

    if (!in_array($curso, ["canto", "piano", "ambos"])) {
        $erros[] = "Curso inválido.";
    }

    if (!in_array($nivel, ["iniciante", "intermediario", "avancado"])) {
        $erros[] = "Nível inválido.";
    }

    // Exibe erros ou continua o processo
    if (!empty($erros)) {
        echo "<h2>⚠️ Erros no cadastro:</h2><ul>";
        foreach ($erros as $erro) {
            echo "<li>$erro</li>";
        }
        echo "</ul><a href='javascript:history.back()'>Voltar</a>";
    } else {
        // Aqui você pode salvar os dados no banco ou enviar por e-mail
        echo "<h2>✅ Cadastro realizado com sucesso!</h2>";
        echo "<p>Bem-vindo(a), <strong>$nome</strong>! Entraremos em contato pelo e-mail <strong>$email</strong>.</p>";
    }
} else {
    echo "<p>Formulário não enviado corretamente.</p>";
}
?>