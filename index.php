<?php
session_start();

function validar_login($login) {
    return preg_match('/^(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_+{}|:<>?.]{6,16}$/', $login);
}

function validar_senha($senha) {
    return preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_+{}|:<>?.]{6,15}$/', $senha);
}



$loginErro = '';
$senhaErro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $senha = $_POST["senha"];
     
    if (!validar_login($login)) {
        $loginErro = "O login deve conter ao menos 1 caractere especial, sem espaços, e ter entre 6 e 16 caracteres.";
    }

    if (!validar_senha($senha)) {
        $senhaErro = "A senha deve conter ao menos 1 letra maiúscula, 1 caractere especial, e ter entre 6 e 15 caracteres.";
    }

    if (empty($loginErro) && empty($senhaErro)) {
        $tipos_usuarios = ['usuario', 'fornecedor', 'funcionario'];
        $usuario_encontrado = false;

        foreach ($tipos_usuarios as $tipo) {
            $caminho = "cadastros/{$tipo}.txt";
            if (file_exists($caminho)) {
                $usuarios = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                foreach ($usuarios as $usuario) {
                    $dados_usuario = explode(", ", $usuario);

                    $usuarioNome = str_replace("User: ", "", $dados_usuario[0]);
                    $usuarioSenhaHash = $dados_usuario[2];

                    if ($login == $usuarioNome && password_verify($senha, $usuarioSenhaHash)) {
                        $_SESSION["login"] = $usuarioNome;
                        $_SESSION["tipo_usuario"] = $tipo;
                        header("Location: /TarefaRecesso/menu.php");
                        exit;
                    }
                }
            }
        }

        $erro = "Login ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
    <link rel="stylesheet" href="css/indescritivel.css">
    <style>
        body {
            background-image: url("img/imagemfundo2.jpg");
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="logo">Eskina do Pão</h2>
        <form method="post">
            <label for="login"></label>
            <input type="text" id="login" name="login" class="form-control" required 
                   title="O login deve conter ao menos 1 caractere especial, sem espaços, e ter entre 6 e 16 caracteres" 
                   placeholder="Login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : ''; ?>">
                   <span id="msgLogin" style="color: red; display: none;">O login deve conter ao menos 1 caractere especial, sem espaços, e ter entre 6 e 16 caracteres</span>
            <br>

            <label for="senha"></label>
            <input type="password" id="senha" name="senha" class="form-control" required 
                   title="A senha deve conter ao menos 1 letra maiúscula, 1 caractere especial, e ter entre 6 e 15 caracteres" 
                   placeholder="Senha">
                   <span id="msgSenha" style="color: red; display: none;">A senha deve conter ao menos 1 letra maiúscula, 1 caractere especial, e ter entre 6 e 15 caracteres</span>
                   <br>
            <input type="submit" value="Logar" class="btn">
            <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>

            <div class="links">
                <p>Não tem cadastro? <a href="cadastro_cliente.php">Cadastre-se</a></p>
                <p>Esqueceu a senha? <a href="#">Recuperar senha</a></p>
            </div>
        </form>
    </div>

    <script>
    document.getElementById('login').addEventListener('input', function () {
        const input = this.value;
        const msgLogin = document.getElementById('msgLogin');
        const regexLogin = /^(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_+{}|:<>?.]{6,16}$/;

        if (!regexLogin.test(input)) {
            msgLogin.style.display = 'block';
        } else {
            msgLogin.style.display = 'none';
        }
    });

    document.getElementById('senha').addEventListener('input', function () {
        const input = this.value;
        const msgSenha = document.getElementById('msgSenha');
        const regexSenha = /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}|:<>?.])[a-zA-Z0-9!@#$%^&*()_+{}|:<>?.]{6,15}$/;

        if (!regexSenha.test(input)) {
            msgSenha.style.display = 'block';
        } else {
            msgSenha.style.display = 'none';
        }
    });
</script>

</body>
</html>
