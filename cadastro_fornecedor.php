<?php
if (!empty($_POST)) {
  
    function validar_login($login) {
    
      return preg_match('/^(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_.+{}|:<>?]{6,16}$/', $login);
  }

  
  function validar_senha($senha) {
    
      return preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_.+{}|:<>?]{6,15}$/', $senha);
  }

   
    function validar_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

      
        $soma = 0;
        $multiplicador = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicador[$i];
        }
        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

       
        $soma = 0;
        $multiplicador = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $multiplicador[$i];
        }
        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

   
        return ($cnpj[12] == $digito1 && $cnpj[13] == $digito2);
    }

  
    $caminho = "cadastros/fornecedor.txt";
    $fornecedores = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $cnpj_ja_cadastrado = false;
    $email_ja_cadastrado = false;

    foreach ($fornecedores as $fornecedor) {
        $dados_fornecedor = explode(", ", $fornecedor);
        if ($dados_fornecedor[1] == $_POST['cnpj']) {
            $cnpj_ja_cadastrado = true;
        }
        if ($dados_fornecedor[12] == $_POST['email']) {
            $email_ja_cadastrado = true;
        }
    }

    $login_valido = validar_login($_POST['user']);
    $senha_valida = validar_senha($_POST['senha']);
    $cnpj_valido = validar_cnpj($_POST['cnpj']);

    if (!$login_valido) {
        $erro = "Login inválido! Deve ter ao menos 1 caractere especial, sem espaços, e ter entre 6 e 16 caracteres.";
    } elseif (!$senha_valida) {
        $erro = "Senha inválida! Deve conter ao menos 1 letra maiúscula, 1 caractere especial e ter entre 6 e 15 caracteres.";
    } elseif (!$cnpj_valido) {
        $erro = "CNPJ inválido!";
    } elseif ($cnpj_ja_cadastrado) {
        $erro = "CNPJ já cadastrado!";
    } elseif ($email_ja_cadastrado) {
        $erro = "E-mail já cadastrado!";
    } else {
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $fornecedor = array(
            $_POST['user'], // --> 0
            $_POST['cnpj'], // --> 1
            $senha_hash, // Armazenar a senha hash --> 2
            $_POST['cep'], // --> 3
            $_POST['nome'], // --> 4
            $_POST['rua'], // --> 5
            $_POST['numero'], // --> 6
            $_POST['complemento'], // --> 7
            $_POST['bairro'], // --> 8
            $_POST['cidade'], // --> 9
            $_POST['uf'], // --> 10
            $_POST['telefone'], // --> 11
            $_POST['email'], // --> 12
            $_POST['representante'], // --> 13
            $_POST['categoria'] // --> 14
        );

        $conteudo = "User: ";

        foreach ($fornecedor as $dados) {
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
    <title>Cadastro de Fornecedor</title>
    <link rel="stylesheet" href="css/cadastrox.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Fornecedor</h1>
        <?php if (isset($erro)) { ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php } elseif (isset($mensagem)) { ?>
            <p style="color: green;"><?php echo $mensagem; ?></p>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nome">Razão Social:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="cnpj">CNPJ:</label>
            <input type="text" id="cnpj" name="cnpj" required oninput="this.value = formatarCNPJ(this.value)"><br><br>

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
            <input type="email" id="email" name="email" required oninput="this.value = formatarEmail(this.value)"><br><br>

            <label for="representante">Nome do Representante:</label>
            <input type="text" id="representante" name="representante" required><br><br>

            <label for="categoria">Categoria:</label>
              <select id="categoria" name="categoria" required>
              <option value="">Selecione</option>
              <option value="Alimentos">Alimentos</option>
              <option value="Bebidas">Bebidas</option>
              <option value="Eletrodomésticos">Eletrodomésticos</option>
              <option value="Eletrônicos">Eletrônicos</option>
              <option value="Limpeza">Limpeza</option>
              <option value="Material de Escritório">Material de Escritório</option>
              <option value="Papelaria">Papelaria</option>
              <option value="Utilidades Domésticas">Utilidades Domésticas</option>
              <option value="Outros">Outros</option>
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
    <script src="js/cadastro_fornecedor.js"></script>
</body>
</html>
