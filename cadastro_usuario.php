<?php
if (!empty($_POST)) {
    function validar_login($login) {
        return preg_match('/^(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_.+{}|:<>?]{6,16}$/', $login);
    }
    function validar_senha($senha) {
        return preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_.+{}|:<>?]{6,15}$/', $senha);
    }

    $caminho = "cadastros/usuario.txt";
    $usuarios = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $email_ja_cadastrado = false;

    foreach ($usuarios as $usuario) {
        $dados_usuario = explode(", ", $usuario);
        if ($dados_usuario[1] == $_POST['email']) {
            $email_ja_cadastrado = true;
        }
    }
    $login_valido = validar_login($_POST['user']);
    $senha_valida = validar_senha($_POST['senha']);

    if (!$login_valido) {
        $erro = "Login inválido! Deve ter ao menos 1 caractere especial, sem espaços, e ter entre 6 e 16 caracteres.";
    } elseif (!$senha_valida) {
        $erro = "Senha inválida! Deve conter ao menos 1 letra maiúscula, 1 caractere especial e ter entre 6 e 15 caracteres.";
    } elseif ($email_ja_cadastrado) {
        $erro = "E-mail já cadastrado!";
    } else { 
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $usuario = array(
            $_POST['user'], // --> 0
            $_POST['email'], // --> 1
            $senha_hash, // Armazenar a senha hash --> 2
            $_POST['nome'], // --> 3
            $_POST['cep'], // --> 4
            $_POST['rua'], // --> 5
            $_POST['numero'], // --> 6
            $_POST['complemento'], // --> 7
            $_POST['bairro'], // --> 8
            $_POST['cidade'], // --> 9
            $_POST['uf'], // --> 10
            $_POST['telefone'], // --> 11
            $_POST['receber_promocoes'], // --> 12
            $_POST['ja_fez_compra'] // --> 13
        );

        $conteudo = "User: ";

        foreach ($usuario as $dados) {
            $conteudo .= $dados . ", ";
        }

        $conteudo .= "\n";

        if (file_put_contents($caminho, $conteudo, FILE_APPEND)) {
            $mensagem = "Dados cadastrados com sucesso!";
        } else {
            $erro = "Erro ao cadastrar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuario</title>
    <link rel="stylesheet" href="css/cadastrox.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuario</h1>
        <?php if (isset($erro)) { ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php } elseif (isset($mensagem)) { ?>
            <p style="color: green;"><?php echo $mensagem; ?></p>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required oninput="this.value = formatarCPF(this.value)"><br><br>

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required>
            <button type="button" id="buscar-cep" onclick="pesquisacep(document.getElementById('cep').value)">Buscar CEP</button><br><br>

            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua" required><br><br>

            <label for="numero">Nº:</label>
            <input type="text" id="numero" name="numero" required><br><br>

            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento"><br><br>

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" required><br><br>

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required><br><br>

            <label for="uf">UF:</label>
            <select id="uf" name="uf" required>
                <?php
                $ufs = array("AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO");
                foreach ($ufs as $uf) {
                    echo "<option value='$uf'>$uf</option>";
                }
                ?>
            </select><br><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required oninput="this.value = formatarTelefone(this.value)"><br><br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="receber_promocoes">Gostaria de receber promoções no email?</label>
            <select id="receber_promocoes" name="receber_promocoes" required>
                <option value="">Selecione</option>
                <option value="sim">Sim</option>
                <option value="nao">Não</option>
            </select><br><br>

            <label for="ja_fez_compra">Primeira vez na loja?</label>
            <select id="ja_fez_compra" name="ja_fez_compra" required>
                <option value="">Selecione</option>
                <option value="sim">Sim</option>
                <option value="nao">Não</option>
            </select><br><br>

            <label for="user">Nome de Usuario:</label>
            <input type="text" id="user" name="user" placeholder="Login (mínimo 6 caracteres)" required><br>
            <span id="msgLogin" style="color: red; display: none;">O login deve ter ao menos 1 caractere especial, sem espaços, e ter entre 6 e 16 caracteres.</span>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Senha (mínimo 6 caracteres)" required><br>
            <span id="msgSenha" style="color: red; display: none;">A senha deve conter ao menos 1 letra maiúscula, 1 caractere especial e ter entre 6 e 15 caracteres.</span><br><br>

            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
            <button type="button" id="voltar"><a href="menu.php">Voltar</a></button>
        </form>
        <script>
            document.getElementById('user').addEventListener('input', function () {
                const input = this.value;
                const msgLogin = document.getElementById('msgLogin');
                const regexLogin = /^(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_.+{}|:<>?]{6,16}$/;

                if (!regexLogin.test(input)) {
                    msgLogin.style.display = 'block';
                } else {
                    msgLogin.style.display = 'none';
                }
            });

            document.getElementById('senha').addEventListener('input', function () {
                const input = this.value;
                const msgSenha = document.getElementById('msgSenha');
                const regexSenha = /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_.+{}|:<>?]{6,15}$/;

                if (!regexSenha.test(input)) {
                    msgSenha.style.display = 'block';
                } else {
                    msgSenha.style.display = 'none';
                }
            });
        </script>
    </div>
    <script src="js/cadastro_usuario.js"></script>
</body>
</html>
