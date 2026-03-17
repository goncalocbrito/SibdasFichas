<?php
// ---------------------------------------------------------------------------
// SEGURANÇA: Impede que o utilizador aceda diretamente a este script.
// Este ficheiro deve ser acedido apenas através de submissão de formulário (POST).
// Se for acedido diretamente (por URL) recebe a informação de Acesso Inválido
// ----------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se não for uma submissão do formulário, termina o script
    exit('Acesso inválido');
}
?>

<?php
// Mostrar os dados recebidos pelo formulário através do método POST
// O nome dos campos (entre aspas) deve ser igual ao atributo "name" no login.php
echo "Utilizador: " . $_POST['text_username'] . "<br>"; // Mostra o username inserido
echo "Password: " . $_POST['text_password']; // Mostra a password inserida
// Em produção, **nunca** se deve mostrar a password assim — isto é apenas para testes!
?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/nav.php'; ?>    

    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-md-9 col-lg-10 p-4">
                <section>
                    <h2>ISEP Ginásio</h2>
                    <p>Escolhe uma opção no menu lateral para continuar.</p>
                </section>
            </main>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>