<?php
    // Inicializa a sessão
    session_start();

    // Desativa todas as variáveis de sessão
    $_SESSION = array();

    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login
    header('Location: index.php');
    exit;