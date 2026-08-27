
<?php

session_start();

require "conexao.php";

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

$stmt = $pdo->prepare(
    "SELECT * FROM usuarios WHERE email = ?"
);

$stmt->execute([$email]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (
    !$usuario ||
    !password_verify($senha, $usuario["senha"])
) {
    header(
        "Location: login.php?erro=E-mail ou senha incorretos."
    );
    exit;
}

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["usuario_nome"] = $usuario["nome"];
$_SESSION["usuario_email"] = $usuario["email"];

header("Location: index.php");
exit;