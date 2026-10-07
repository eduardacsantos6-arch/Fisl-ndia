<?php

/**
 * Bootstrap file for PHPUnit
 * Configura o autoloader para as classes do projeto
 */

// Diretório raiz do projeto
$projectRoot = dirname(__DIR__);

// Carrega o composer autoloader PRIMEIRO
if (file_exists($projectRoot . '/vendor/autoload.php')) {
    require_once $projectRoot . '/vendor/autoload.php';
}

// Depois registra um autoloader simples para o projeto
spl_autoload_register(function ($class) use ($projectRoot) {
    // Remove o namespace
    $parts = explode('\\', $class);
    $className = array_pop($parts);
    $namespace = implode('\\', $parts);

    // Mapeia namespaces para diretórios
    $namespacePath = str_replace('\\', '/', $namespace);
    
    // Tenta encontrar o arquivo da classe
    $filePath = $projectRoot . '/' . $namespacePath . '/' . $className . '.php';

    if (file_exists($filePath)) {
        require_once $filePath;
        return true;
    }

    return false;
});