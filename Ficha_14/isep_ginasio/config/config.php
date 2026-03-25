<?php
define('BASE_URL', '/SIBDAS/Ficha_14/isep_ginasio');

// Configurações globais da aplicação
define('APP_NAME', 'ISEP Porto Ginásio');
define('APP_VERSION', '1.0.0');
define('APP_COPYRIGHT', '© 2025 ISEP');

define('MYSQL_HOST', 'localhost');
define('MYSQL_PORT', '3306');
define('MYSQL_DATABASE', 'isep-ginasio');
define('MYSQL_USERNAME', 'sibdas2025');
define('MYSQL_PASSWORD', '3LduNkJe55lVk0ia0RXvVQ1tZpA7OW5');
define('MYSQL_AES_KEY', 'Vduu47qL51hLn6bkYkY6NlO1nivsmdfD');

// --------------------------------------------------------------------
// Segurança – Encriptação com OpenSSL
// --------------------------------------------------------------------
define('OPENSSL_METHOD', 'AES-256-CBC'); // Algoritmo simétrico robusto
define('OPENSSL_KEY', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'); // Chave de 32 caracteres
define('OPENSSL_IV', 'BzKAbjuREsHgnw56'); // Vetor de inicialização (16caracteres)

?>