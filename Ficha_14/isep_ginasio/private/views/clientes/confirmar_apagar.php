<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

//Desencriptar e validar o ID do Cliente
$idClientEncrypted = $_GET['id_cliente'] ?? null;
$idClient = aes_decrypt($idClientEncrypted);

if (!$idClient || !is_numeric($idClient)) {
    header('Location: ' . BASE_URL . '/private/views/clientes/lista.php');
    exit;
}

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );

    $stmt = $ligacao->prepare("UPDATE clientes SET cliente_ativo = 0 WHERE id = :id");
    $stmt->bindParam(':id', $idClient, PDO::PARAM_INT);
    $stmt->execute();

    header ('Location: lista.php');
    exit;
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}
