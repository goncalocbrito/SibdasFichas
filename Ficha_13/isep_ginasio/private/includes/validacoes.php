<?php

function validar_nome(string $nome): array {
    $erros = [];
    $nome = trim($nome);

    if ($nome === '') {
        $erros[] = "O campo Nome é obrigatório.";
    } elseif (preg_match('/\d/', $nome)) {
        $erros[] = "O campo Nome não pode conter números.";
    }

    return $erros;
}

function validar_morada(string $morada): array {
    $erros = [];
    $morada = trim($morada);

    if ($morada === '') {
        $erros[] = "O campo Morada é obrigatório.";
    }

    return $erros;
}

function validar_codigo_postal(string $cp): array {
    $erros = [];
    $cp = trim($cp);

    if ($cp === '') {
        $erros[] = "O campo Código Postal é obrigatório.";
    } elseif (!preg_match('/^\d{4}-\d{3}$/', $cp)) {
        $erros[] = "Código Postal inválido (ex: 4000-007).";
    }

    return $erros;
}

function validar_cidade(string $cidade): array {
    $erros = [];
    $cidade = trim($cidade);

    if ($cidade === '') {
        $erros[] = "O campo Cidade é obrigatório.";
    } elseif (preg_match('/\d/', $cidade)) {
        $erros[] = "O campo Cidade não pode conter números.";
    }

    return $erros;
}

function validar_telefone(string $telefone): array {
    $erros = [];
    $telefone = trim($telefone);

    if ($telefone === '') {
        $erros[] = "O campo Telefone é obrigatório.";
    } elseif (!preg_match('/^9\d{8}$/', $telefone)) {
        $erros[] = "O número de telefone não é válido. Deve começar por 9 e ter 9 dígitos.";
    }

    return $erros;
}

function validar_email(string $email): array {
    $erros = [];
    $email = trim($email);

    if ($email === '') {
        $erros[] = "O campo Email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O endereço de email não é válido.";
    }

    return $erros;
}

function validar_sexo(string $sexo): array {
    $erros = [];
    $sexo = trim($sexo);

    if ($sexo === '') {
        $erros[] = "O campo Género é obrigatório.";
    } elseif (!in_array($sexo, ['m', 'f'])) {
        $erros[] = "O género selecionado é inválido.";
    }

    return $erros;
}

function validar_data_nascimento(string $dnasc): array {
    $erros = [];
    $dnasc = trim($dnasc);

    if ($dnasc === '') {
        $erros[] = "O campo Data de Nascimento é obrigatório.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dnasc)) {
        $erros[] = "Formato de data inválido. Use AAAA-MM-DD.";
    } else {
        $partes = explode('-', $dnasc);

        if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
            $erros[] = "Data de nascimento inválida.";
        }
    }

    return $erros;
}

function validar_estado_civil(string $estado): array {
    $erros = [];
    $estado = trim($estado);

    if ($estado === '') {
        $erros[] = "Estado civil não selecionado.";
    } elseif (!in_array($estado, ['solt', 'casd', 'ufat'])) {
        $erros[] = "O estado civil selecionado é inválido.";
    }

    return $erros;
}

function validar_sistema_saude(string $sistema): array {
    $erros = [];
    $sistema = trim($sistema);

    if ($sistema === '') {
        $erros[] = "Sistema de saúde não preenchido.";
    }

    return $erros;
}

function validar_profissao(string $profissao): array {
    $erros = [];
    $profissao = trim($profissao);

    if ($profissao === '') {
        $erros[] = "Profissão é obrigatória.";
    } elseif (preg_match('/\d/', $profissao)) {
        $erros[] = "A profissão não pode conter números.";
    }

    return $erros;
}

function validar_cliente(array $dados): array {
    $erros = [];

    $nome = $dados['nome_cliente'] ?? '';
    $morada = $dados['morada_cliente'] ?? '';
    $cp = $dados['cp_cliente'] ?? '';
    $cidade = $dados['cid_cliente'] ?? '';
    $telefone = $dados['tel_cliente'] ?? '';
    $email = $dados['email_cliente'] ?? '';
    $sexo = $dados['radio_gender'] ?? '';
    $dnasc = $dados['dnasc_cliente'] ?? '';
    $estado = $dados['estaciv_cliente'] ?? '';
    $sistema = $dados['campo_opcao'] ?? '';
    $profissao = $dados['profissao_cliente'] ?? '';

    $erros = array_merge($erros, validar_nome($nome));
    $erros = array_merge($erros, validar_morada($morada));
    $erros = array_merge($erros, validar_codigo_postal($cp));
    $erros = array_merge($erros, validar_cidade($cidade));
    $erros = array_merge($erros, validar_telefone($telefone));
    $erros = array_merge($erros, validar_email($email));
    $erros = array_merge($erros, validar_sexo($sexo));
    $erros = array_merge($erros, validar_data_nascimento($dnasc));
    $erros = array_merge($erros, validar_estado_civil($estado));
    $erros = array_merge($erros, validar_sistema_saude($sistema));
    $erros = array_merge($erros, validar_profissao($profissao));

    return $erros;
}

?>