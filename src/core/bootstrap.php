<?php
// src/core/bootstrap.php

// =================================================================
// 1. DEFINIÇÃO DE CONSTANTES E AMBIENTE
// =================================================================
define("BASE_PATH", dirname(__DIR__));
define("PUBLIC_PATH", BASE_PATH . "/public");
define("CORE_PATH", __DIR__);

// Informa os submódulos que estão a rodar dentro do ecossistema principal
define("WARANAS_MASTER_CORE", true);

// =================================================================
// 2. SESSÃO E VARIÁVEIS DE ESTADO
// =================================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();

    // Variável principal de estado que você renomeou recentemente
    if (!isset($_SESSION["SESSION"])) {
        $_SESSION["SESSION"] = [];
    }
}

// =================================================================
// 3. EXECUÇÃO DO NÚCLEO (ESCOPO GLOBAL)
// =================================================================

// O Router processa a URL e cria $basePath e $targetFile
require_once CORE_PATH . "/router.php";

// O Render valida a segurança e faz o require cru do template final
require_once CORE_PATH . "/render.php";
