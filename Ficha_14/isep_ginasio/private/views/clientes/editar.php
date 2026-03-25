<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado 
require_once __DIR__ . '/../../includes/validacoes.php';

if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/public/login.php');
    exit;
}

//Desencriptar e validar o ID do Cliente
$idClientEncrypted = $_GET['id_cliente'] ?? null;
$idClient = aes_decrypt($idClientEncrypted);

if (!$idClient || !is_numeric($idClient)) {
    header('Location: ' . BASE_URL . '/private/views/clientes/lista.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoNome = $_POST['nome_cliente'] ?? '';
    $novoEmail = $_POST['email_cliente'] ?? '';
    $novaMorada = $_POST['morada_cliente'] ?? '';
    $novoTelefone = $_POST['tel_cliente'] ?? '';

    //$erros = validar_nome($novoNome);
    $erros = [];
    $erros = array_merge($erros, validar_nome($novoNome));
    $erros = array_merge($erros, validar_email($novoEmail));
    $erros = array_merge($erros, validar_morada($novaMorada));
    $erros = array_merge($erros, validar_telefone($novoTelefone));

    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );

            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $ligacao->prepare("
                UPDATE clientes
                SET nome = :nome,
                    email = :email,
                    morada = :morada,
                    telefone = :telefone
                WHERE id = :id
            ");

            $stmt->bindParam(':nome', $novoNome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $novoEmail, PDO::PARAM_STR);
            $stmt->bindParam(':morada', $novaMorada, PDO::PARAM_STR);
            $stmt->bindParam(':telefone', $novoTelefone, PDO::PARAM_STR);
            $stmt->bindParam(':id', $idClient, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: lista.php');
            exit;

        } catch (PDOException $err) {
            $erros[] = "Erro ao atualizar o nome: " . $err->getMessage();
        }
    }
}

/*
// Recolhe o ID do cliente da URL
$idClient = $_GET['id_cliente'] ?? null;

if (!$idClient) {
    header('Location: ' . BASE_URL . '/private/views/clientes/lista.php');
    exit;
}
*/

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Preparar e executar a query com segurança
    $stmt = $ligacao->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->bindParam(':id', $idClient, PDO::PARAM_INT);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_OBJ);
    
    // Se não encontrou o cliente, redireciona
    if (!$cliente) {
        header('Location: ' . BASE_URL . '/private/views/clientes/lista.php');
        exit;
    }

    //$erro = ''; apagar senao o erro nao e exibido
} catch (PDOException $err) {
    $erro = "Erro na ligação à base de dados.";
    $cliente = null;
}
// Fecha a ligação
$ligacao = null;

// Para testar (temporário)
//echo ($idClient);

include '../../includes/header.php';
include '../../includes/nav.php';

?>

        <div class="container-fluid">
            <div class="row">
                <?php include '../../includes/sidebar.php'; ?>
                
                <!-- Conteúdo Principal -->
                <main class="col-md-9 col-lg-10 p-4">

                    <div class="d-flex justify-content-center mt-4">

                        <div class="card w-100 shadow rounded" style="max-width: 1200px;">

                            <div class="card-body">

                                <h2 class="mb-4">
                                    <strong>
                                        <i class="fa-solid fa-users me-2"></i> Atualização de Dados CLIENTES
                                    </strong>
                                </h2>

                                <hr>

                                <form action="editar.php?id_cliente=<?= $idClientEncrypted ?>" method="post" novalidate>

                                    <!-- Linhas e colunas com campos organizados -->

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="texto_nome" class="form-label">Nome Completo</label>
                                            <input type="text"
                                                class="form-control"
                                                id="texto_nome"
                                                name="nome_cliente"
                                                value="<?= htmlspecialchars($cliente->nome) ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="texto_endereco" class="form-label">
                                                Morada <small>(Nº Porta, Andar)</small>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                id="texto_endereco"
                                                name="morada_cliente"
                                                value="<?= htmlspecialchars($cliente->morada) ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-3">
                                            <label for="texto_cp" class="form-label">Código Postal</label>
                                            <input type="text"
                                                class="form-control"
                                                id="texto_cp"
                                                name="cp_cliente"
                                                value="4200-072"
                                                required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="texto_cidade" class="form-label">Cidade</label>
                                            <input type="text"
                                                class="form-control"
                                                id="texto_cidade"
                                                name="cid_cliente"
                                                value="<?= htmlspecialchars($cliente->cidade) ?>"
                                                required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="texto_cliente" class="form-label">Telefone</label>
                                            <input type="text"
                                                class="form-control"
                                                id="texto_cliente"
                                                name="tel_cliente"
                                                value="<?= htmlspecialchars($cliente->telefone) ?>"
                                                required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="texto_email" class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control"
                                                id="texto_email"
                                                name="email_cliente"
                                                value="<?= htmlspecialchars($cliente->email) ?>"
                                                required>
                                        </div>

                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-6">
                                            <label class="form-label">Sexo</label>

                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="radio_gender"
                                                        id="radio_m"
                                                        value="m" <?= $cliente->sexo == 'm' ? 'checked' : '' ?>
                                                        checked>
                                                    <label class="form-check-label" for="radio_m">
                                                        Masculino
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="radio_gender"
                                                        id="radio_f"
                                                        value="f" <?= $cliente->sexo == 'f' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="radio_f">
                                                        Feminino
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="texto_dnasc" class="form-label">
                                                Data de nascimento
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                id="texto_dnasc"
                                                name="dnasc_cliente"
                                                value="<?= date('Y-m-d', strtotime($cliente->data_nascimento)) ?>"
                                                required>
                                        </div>

                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-4">
                                            <label for="texto_estcivil" class="form-label">
                                                Estado Civil
                                            </label>

                                            <select class="form-select"
                                                    id="texto_estcivil"
                                                    name="estaciv_cliente">
                                                <option>Escolha uma opção</option>
                                                <option value="solt" selected>Solteiro</option>
                                                <option value="casd">Casado</option>
                                                <option value="ufat">União de Facto</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="texto_SSaude" class="form-label">
                                                Sistema de Saúde
                                            </label>

                                            <input type="text"
                                                class="form-control"
                                                id="texto_SSaude"
                                                name="campo_opcao"
                                                list="sistemasaude"
                                                value="ADSE">

                                            <datalist id="sistemasaude">
                                                <option value="SNS">
                                                <option value="ADSE">
                                                <option value="SMAS">
                                                <option value="CTT">
                                                <option value="PSP">
                                            </datalist>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="profissao" class="form-label">
                                                Profissão
                                            </label>

                                            <input type="text"
                                                class="form-control"
                                                id="profissao"
                                                name="profissao_cliente"
                                                value="Engenheiro Informático">
                                        </div>

                                    </div>

                                    <!-- Botões -->
                                    <div class="d-flex justify-content-end gap-2 mb-4">

                                        <a href="lista.php" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-xmark me-1"></i> Cancelar
                                        </a>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-regular fa-floppy-disk me-1"></i> Guardar
                                        </button>

                                    </div>

                                    <!-- Área de erros -->
                                    <?php if (!empty($erros)): ?>
                                        <div class="alert alert-danger text-center" role="alert">
                                            <?php foreach ($erros as $erro): ?>
                                                <div><?= htmlspecialchars($erro) ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </form>

                            </div>

                        </div>

                    </div>

                </main>

            </div>       
        </div>

<?php include '../../includes/footer.php'; ?>
