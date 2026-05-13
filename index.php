<?php
/**
 * Arquivo de entrada principal do sistema.
 * Define a raiz e inicializa o núcleo (core).
 */

// Define o caminho base da aplicação
define("ROOT_PATH", __DIR__);

// Carrega o arquivo de inicialização (bootstrap)
// O bootstrap já carrega o router.php e o render.php
require_once ROOT_PATH . "/src/core/bootstrap.php";

// Processa a requisição atual através do Router
routeRequest($_SERVER["REQUEST_URI"]);
