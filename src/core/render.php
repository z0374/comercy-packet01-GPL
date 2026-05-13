<?php
// src/core/render.php

/**
 * Carrega e renderiza ficheiros PHP ou serve ficheiros estáticos dos submódulos.
 */
function serveContent(string $basePath, string $targetFile): void
{
    $filePath = realpath($basePath . $targetFile);

    // Validação de segurança: garantir que o ficheiro existe e não escapa ao diretório base (prevenção de Path Traversal)
    if (
        $filePath &&
        strpos($filePath, realpath($basePath)) === 0 &&
        file_exists($filePath)
    ) {
        // Se for um ficheiro PHP, é interpretado e renderizado
        if (pathinfo($filePath, PATHINFO_EXTENSION) === "php") {
            include $filePath;
        } else {
            // Se for um asset estático, define o cabeçalho correto e serve o conteúdo
            $mimeTypes = [
                "css" => "text/css",
                "js" => "application/javascript",
                "png" => "image/png",
                "jpg" => "image/jpeg",
                "svg" => "image/svg+xml",
                "json" => "application/json",
            ];
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            if (array_key_exists($ext, $mimeTypes)) {
                header("Content-Type: " . $mimeTypes[$ext]);
            }

            readfile($filePath);
            exit();
        }
    } else {
        serveError404();
    }
}

/**
 * Renderiza uma página padrão de recurso não encontrado.
 */
function serveError404(): void
{
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 - Ficheiro não encontrado</h1>";
    echo "<p>O recurso que tentou aceder não se encontra disponível neste servidor.</p>";
    exit();
}
