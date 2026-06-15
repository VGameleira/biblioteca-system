<?php
session_start();

// Limpar todas as variáveis de sessão
$_SESSION = [];

// Destruir o cookie de sessão
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destruir a sessão
session_destroy();

// Redirecionar para o login
header("Location: index.php");
exit;
?>