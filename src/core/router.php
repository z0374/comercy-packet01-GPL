<?php
// src/core/router.php

/**
 * Função responsável por encaminhar os pedidos para os submódulos corretos
 * com base no URI fornecido.
 */
function routeRequest(string $requestUri): void
{
    $path = parse_url($requestUri, PHP_URL_PATH);
    $path = trim($path, "/");

    // Dividir a rota para identificar o módulo alvo
    $segments = explode("/", $path);

    // Mapear o módulo para o diretório correto nos submódulos
    $moduleMap = [
        "commerce" => PUBLIC_PATH . "/commerce",
        "portal" => PUBLIC_PATH . "/portal",
        "catalog" => PUBLIC_PATH . "/catalog",
    ];

    // Verifica o primeiro segmento da URL
    $firstSegment = $segments[0];

    // Se o segmento for explicitamente 'portal' ou 'catalog' (ou 'commerce' acessado diretamente)
    if (!empty($firstSegment) && array_key_exists($firstSegment, $moduleMap)) {
        $module = $firstSegment;
        $moduleBasePath = $moduleMap[$module];

        // Reconstrói o caminho ignorando o nome do módulo na URL
        $targetFile = empty($segments[1])
            ? "/index.php"
            : "/" . implode("/", array_slice($segments, 1));
    } else {
        // Trata o 'commerce' como raiz (fallback)
        // Qualquer coisa que não for portal/catalog cai aqui
        $module = "commerce";
        $moduleBasePath = $moduleMap[$module];

        // Se estiver vazio, joga para o index. Se tiver algo (ex: /carrinho), repassa o caminho inteiro
        $targetFile = empty($firstSegment)
            ? "/index.php"
            : "/" . implode("/", $segments);
    }

    // Chama o render para processar o arquivo final
    serveContent($moduleBasePath, $targetFile);
}
