<?php
// index.php

/**
 * Arquivo de entrada principal do sistema.
 * Define a raiz e inicializa o núcleo (core).
 */

define("ROOT_PATH", __DIR__);

// Carrega o arquivo de inicialização (bootstrap)
require_once ROOT_PATH . "/src/core/bootstrap.php";
