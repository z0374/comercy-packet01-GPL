<?php
// src/core/router.php

// Pega a URL globalmente, ou define '/' se não existir
$requestUri = $_SERVER["REQUEST_URI"] ?? "/";
$path = parse_url($requestUri, PHP_URL_PATH);
$path = trim($path, "/");

// Mapear o módulo para o diretório correto nos submódulos
$moduleMap = [
    "home" => PUBLIC_PATH . "/commerce",
    "portal" => PUBLIC_PATH . "/portal",
    "catalogo" => PUBLIC_PATH . "/catalog",
];

// Inicializa as variáveis de ambiente de roteamento no escopo global
$basePath = "";
$targetFile = "";

// 1. REGRA DA RAIZ: Se o caminho estiver vazio (acessou apenas /)
if (empty($path)) {
    $basePath = $moduleMap["home"];
    $targetFile = "/index.php";
} else {
    // Dividir a rota para identificar o módulo alvo
    $segments = explode("/", $path);
    $firstSegment = $segments[0];

    // 2. REGRA DE MÓDULOS: Começa com /portal, /catalog ou /commerce
    if (array_key_exists($firstSegment, $moduleMap)) {
        $basePath = $moduleMap[$firstSegment];

        // Reconstrói o caminho interno ignorando o nome do módulo
        $targetFile = empty($segments[1])
            ? "/index.php"
            : "/" . implode("/", array_slice($segments, 1));
    } else {
        // 3. FALLBACK: Envia a requisição inteira para o commerce
        $basePath = $moduleMap["commerce"];
        $targetFile = "/" . implode("/", $segments);
    }
}
