<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recolher dados
    $nome = $_POST["nome_cliente"] ?? "";
    $morada = $_POST["morada_cliente"] ?? "";
    $cp = $_POST["cp_cliente"] ?? "";
    $cidade = $_POST["cid_cliente"] ?? "";
    $telefone = $_POST["tel_cliente"] ?? "";
    $email = $_POST["email_cliente"] ?? "";
    $sexo = $_POST["radio_gender"] ?? "";
    $dnasc = $_POST["dnasc_cliente"] ?? "";
    $estado = $_POST["estaciv_cliente"] ?? "";
    $sistema = $_POST["campo_opcao"] ?? "";
    $profissao = $_POST["profissao_cliente"] ?? "";

    // 2. Imprimir os dados (teste)
    echo "<p><strong>Dados recebidos:</strong> Nome: $nome 
    | Morada: $morada | Código Postal: $cp | Cidade: $cidade 
    | Telefone: $telefone | Email: $email | Sexo: " . ($sexo == 'm' ? 'Masculino' : 'Feminino') . " 
    | Data de nascimento: $dnasc | Estado civil: $estado | Sistema de Saúde: $sistema 
    | Profissão: $profissao</p>";

    // 3. Validar os dados
    $erros = [];

    // Remover espaços extra
    $nome = trim($nome);
    $morada = trim($morada);
    $cp = trim($cp);
    $cidade = trim($cidade);
    $telefone = trim($telefone);
    $email = trim($email);
    $estado = trim($estado);
    $sistema = trim($sistema);
    $profissao = trim($profissao);

    // --------------------
    // Validação do Nome
    // --------------------
    if (empty($nome)) {
        $erros[] = "O campo Nome é obrigatório.";
    } elseif (preg_match('/\d/', $nome)) {
        $erros[] = "O campo Nome não pode conter números.";
    }

    // --------------------
    // Validação da Morada
    // --------------------
    if (empty($morada)) {
        $erros[] = "O campo Morada é obrigatório.";
    }

    // --------------------
    // Validação do Código Postal
    // --------------------
    if (empty($cp)) {
        $erros[] = "O campo Código Postal é obrigatório.";
    } elseif (!preg_match('/^\d{4}-\d{3}$/', $cp)) {
        $erros[] = "Código Postal inválido (ex: 4000-007).";
    }

    // --------------------
    // Validação da Cidade
    // --------------------
    if (empty($cidade)) {
        $erros[] = "O campo Cidade é obrigatório.";
    }

    // --------------------
    // Validação do Telefone
    // --------------------
    if (empty($telefone)) {
        $erros[] = "O campo Telefone é obrigatório.";
    } elseif (!preg_match('/^9\d{8}$/', $telefone)) {
        $erros[] = "O número de telefone não é válido. Deve começar por 9 e ter 9 dígitos.";
    }

    // --------------------
    // Validação do Email
    // --------------------
    if (empty($email)) {
        $erros[] = "O campo Email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O endereço de email não é válido.";
    }

    // --------------------
    // Validação do Género
    // --------------------
    if (empty($_POST['radio_gender'])) {
        $erros[] = "O campo Género é obrigatório.";
    }

    // --------------------
    // Estado Civil
    // --------------------
    if (empty($estado)) {
        $erros[] = "Estado civil não selecionado.";
    }

    // --------------------
    // Sistema de Saúde
    // --------------------
    if (empty($sistema)) {
        $erros[] = "Sistema de saúde não preenchido.";
    }

    // --------------------
    // Profissão
    // --------------------
    if (empty($profissao)) {
        $erros[] = "Profissão é obrigatória.";
    }

    // 4. Depuração: mostrar os erros recolhidos
    echo "<pre>"; // torna mais legível no browser
    print_r($erros);
    echo "</pre>";

    // Normalizar entrada
    $nome = ucwords(strtolower($nome)); // Pedro Santos
    $cidade = ucfirst(strtolower($cidade)); // Porto
    $email = strtolower($email); // guimas@email.pt
    $sistema = strtoupper($sistema); // ADSE
    $profissao = ucwords(strtolower($profissao)); // Professor

    echo "<p><strong>Dados normalizados:</strong></p>";
    echo "<ul>";
    echo "<li>Nome: $nome</li>";
    echo "<li>Cidade: $cidade</li>";
    echo "<li>Email: $email</li>";
    echo "<li>Sistema de Saúde: $sistema</li>";
    echo "<li>Profissão: $profissao</li>";
    echo "</ul>";
}

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
                                        <i class="fa-solid fa-users me-2"></i> Inserir novo cliente
                                    </strong>
                                </h2>

                                <hr>

                                <form action="#" method="post" novalidate>

                                    <!-- Linhas e colunas com campos organizados -->

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="texto_nome" class="form-label">Nome Completo</label>
                                            <input type="text" name="nome_cliente" class="form-control"
                                                value="<?= $_POST['nome_cliente'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="texto_endereco" class="form-label">
                                                Morada <small>(Nº Porta, Andar)</small>
                                            </label>
                                            <input type="text" class="form-control" id="texto_endereco" name="morada_cliente"
                                                value="<?= htmlspecialchars($_POST['morada_cliente'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-3">
                                            <label for="texto_cp" class="form-label">Código Postal</label>
                                            <input type="text" name="cp_cliente" class="form-control"
                                                value="<?= htmlspecialchars($_POST['cp_cliente'] ?? '') ?>">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="texto_cidade" class="form-label">Cidade</label>
                                            <input type="text" class="form-control" id="texto_cidade" name="cid_cliente"
                                                value="<?= htmlspecialchars($_POST['cid_cliente'] ?? '') ?>" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="texto_cliente" class="form-label">Telefone</label>
                                            <input type="text" class="form-control" id="texto_cliente" name="tel_cliente"
                                                value="<?= htmlspecialchars($_POST['tel_cliente'] ?? '') ?>" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="texto_email" class="form-label">Email</label>
                                            <input type="email" name="email_cliente" class="form-control"
                                                value="<?= $_POST['email_cliente'] ?? '' ?>">
                                        </div>

                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-6">
                                            <label class="form-label">Sexo</label>

                                            <div>

                                                <div class="form-check form-check-inline">
                                                    <input type="radio" name="radio_gender" value="m"
                                                        <?= (($_POST['radio_gender'] ?? '') === 'm') ? 'checked' : '' ?>>

                                                    <label class="form-check-label" for="radio_m">
                                                        Masculino
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input type="radio" name="radio_gender" value="f"
                                                        <?= (($_POST['radio_gender'] ?? '') === 'f') ? 'checked' : '' ?>>

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
                                                    value="<?= htmlspecialchars($_POST['dnasc_cliente'] ?? '') ?>"
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

                                                <option selected>Escolha uma opção</option>
                                                <option value="solt" <?= (($_POST['estaciv_cliente'] ?? '') == 'solt') ? 'selected' : '' ?>>Solteiro</option>
                                                <option value="casd" <?= (($_POST['estaciv_cliente'] ?? '') == 'casd') ? 'selected' : '' ?>>Casado</option>
                                                <option value="ufat" <?= (($_POST['estaciv_cliente'] ?? '') == 'ufat') ? 'selected' : '' ?>>União de Facto</option>

                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="texto_SSaude" class="form-label">
                                                Sistema de Saúde
                                            </label>

                                            <input type="text" class="form-control" id="texto_SSaude" name="campo_opcao"
                                                list="sistemasaude" value="<?= htmlspecialchars($_POST['campo_opcao'] ?? '') ?>">

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

                                            <input type="text" class="form-control" id="profissao" name="profissao_cliente"
                                                value="<?= htmlspecialchars($_POST['profissao_cliente'] ?? '') ?>">
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
                                    <div class="alert alert-danger text-center" role="alert">
                                        • Erro
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </main>

            </div>       
        </div>

<?php include '../../includes/footer.php'; ?>

