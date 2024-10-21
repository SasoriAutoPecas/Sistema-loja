<?php
session_start(); 


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
    <link rel="stylesheet" href="css/menuzadax.css">
    <style>
        body {
            background-image: url("img/Só Jesus Salva 2.jpg");
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .user-info {
            display: flex;
            align-items: center;
            color: white;
        }
        .user-info img {
            width: 30px;
            height: 30px; 
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <ul>
            <img src="img/Logo.png" alt="Logo" width="100" height="30">
            <li><a href="index.php">Início</a></li>
            <li class="dropdown">
                <a href="#">Cadastro</a>
                <div class="dropdown-content">
                    <a href="cadastro_cliente.php">Cliente</a>
                    <a href="cadastro_funcionario.php">Funcionário</a>
                    <a href="cadastro_fornecedor.php">Fornecedor</a>
                    <a href="cadastro_produto.php">Produto</a>
                    <a href="cadastro_usuario.php">Usuário</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Consultar</a>
                <div class="dropdown-content">
                    <a href="consulta_cliente.php">Cliente</a>
                    <a href="consulta_funcionario.php">Funcionário</a>
                    <a href="consulta_fornecedor.php">Fornecedor</a>
                    <a href="consulta_produto.php">Produto</a>
                    <a href="consulta_usuario.php">Usuário</a>
                </div>
            </li>
            <li><a href="#" id="btn-sair">Sair</a></li>
            <li class="user-info">
                <img src="img/icone.png" alt="Ícone de Conta"> 
                <span><?php echo $_SESSION['login']; ?></span> 
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1>Eskina do Pão</h1>
    </div>
    <footer>
        <p>&copy; 2024 Direitos reservados a Carla Priscila Alves Soares e Kauê Vinicius Soares da Silva. <br> Desenvolvido por Sasori_AutoPeças.</p>
    </footer>
    <div class="popup">
        <div class="content-botao">
            <p>Deseja mesmo se desconectar?</p>
        </div>
        <div class="botao">
            <button id="btn-nao">Não</button>
            <button id="btn-sim">Sim</button>
        </div>
        <div class="fechar">X</div>
    </div>
    <script src="js/menu_zada.js"></script>
</body>
</html>
