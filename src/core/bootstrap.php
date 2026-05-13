<?php
// src/core/bootstrap.php

// Definir as constantes de caminho para navegação consistente
define("CORE_PATH", __DIR__);
define("PUBLIC_PATH", ROOT_PATH . "/src/public");

// Iniciar a sessão e configurar a variável de estado principal
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // Estabelece a variável principal de gestão de estado do utilizador
    if (!isset($_SESSION["SESSION"])) {
        $_SESSION["SESSION"] = [];
    }
}

// Carregar as dependências funcionais do núcleo
require_once CORE_PATH . "/render.php";
require_once CORE_PATH . "/router.php"; 
