<?php
// src/core/render.php

// 1. Garante que o router já definiu os caminhos
if (!isset($basePath) || !isset($targetFile)) {
    header("HTTP/1.0 404 Not Found");
    exit("<h1>404 - Caminho não definido</h1>");
}

// 2. Proteção contra ficheiros/pastas ocultas (ex: .git, .env)
if (str_starts_with($targetFile, ".") || strpos($targetFile, "/.") !== false) {
    header("HTTP/1.0 403 Forbidden");
    exit("<h1>403 - Acesso Negado</h1>");
}

$filePath = realpath($basePath . $targetFile);
$realBasePath = realpath($basePath);

// 3. Validação estrita de segurança (impede Path Traversal e valida existência real)
if (
    !$filePath ||
    !$realBasePath ||
    strpos($filePath, $realBasePath) !== 0 ||
    !file_exists($filePath)
) {
    header("HTTP/1.0 404 Not Found");
    exit("<h1>404 - Ficheiro não encontrado</h1>");
}

// =================================================================
// 4. RENDERIZAÇÃO CRUA (SEM ENCAPSULAMENTO)
// =================================================================

if (pathinfo($filePath, PATHINFO_EXTENSION) === "php") {
    // Faz apenas o require do ficheiro PHP no ESCOPO GLOBAL.
    // Variáveis como $script_files ou globais da Waranas Library fluirão perfeitamente.
    require $filePath;
} else {
    // 5. Servidor de Assets Estáticos (CSS, JS, Imagens, etc.)
    $mimeTypes = [
        "css" => "text/css",
        "js" => "application/javascript",
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "svg" => "image/svg+xml",
        "json" => "application/json",
        "ico" => "image/x-icon",
        "woff" => "font/woff",
        "woff2" => "font/woff2",
        "ttf" => "font/ttf",
        "eot" => "application/vnd.ms-fontobject",
    ];

    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if (array_key_exists($ext, $mimeTypes)) {
        header("Content-Type: " . $mimeTypes[$ext]);
    }

    // Entrega o ficheiro e encerra a execução para não enviar lixo no final
    readfile($filePath);
    exit();
}
