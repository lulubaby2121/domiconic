
<?php

require "conexao.php";

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";
$confirmar = $_POST["confirmar"] ?? "";

if (
    $nome === "" ||
    $email === "" ||
    $senha === ""
) {
    header("Location: cadastro.php?erro=Preencha todos os campos.");
    exit;
}

if ($senha !== $confirmar) {
    header("Location: cadastro.php?erro=As senhas não são iguais.");
    exit;
}

if (strlen($senha) < 6) {
    header("Location: cadastro.php?erro=A senha deve ter pelo menos 6 caracteres.");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: cadastro.php?erro=E-mail inválido.");
    exit;
}

$consulta = $pdo->prepare(
    "SELECT id FROM usuarios WHERE email = ?"
);

$consulta->execute([$email]);

if ($consulta->fetch()) {
    header("Location: cadastro.php?erro=Este e-mail já está cadastrado.");
    exit;
}

$senhaHash = password_hash(
    $senha,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare(
    "INSERT INTO usuarios (nome, email, senha)
     VALUES (?, ?, ?)"
);

$stmt->execute([
    $nome,
    $email,
    $senhaHash
]);

header("Location: login.php?sucesso=Cadastro realizado com sucesso!");
exit;