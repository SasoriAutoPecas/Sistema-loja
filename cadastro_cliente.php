<?php
if (!empty($_POST)) {
  
  $caminho = "cadastros/cliente.txt";
  $clientes = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $cpf_ja_cadastrado = false;
  $email_ja_cadastrado = false;

  foreach ($clientes as $cliente) {
    $dados_cliente = explode(", ", $cliente);
    if ($dados_cliente[1] == $_POST['cpf']) {
      $cpf_ja_cadastrado = true;
    }
    if ($dados_cliente[9] == $_POST['email']) {
      $email_ja_cadastrado = true;
    }
  }

  if ($cpf_ja_cadastrado) {
    $erro = "CPF já cadastrado!";
  } elseif ($email_ja_cadastrado) {
    $erro = "E-mail já cadastrado!";
  } else {
    $cliente = array(
      $_POST['nome'],
      $_POST['cpf'],
      $_POST['cep'],
      $_POST['rua'],
      $_POST['numero'],
      $_POST['complemento'],
      $_POST['bairro'],
      $_POST['cidade'],
      $_POST['uf'],
      $_POST['telefone'],
      $_POST['email']
    );

    $conteudo = "Cliente: ";

    foreach ($cliente as $dados) {
      $conteudo .= $dados . ", ";
    }

    $conteudo .= "\n";

    if (file_put_contents($caminho, $conteudo, FILE_APPEND)) {
      $mensagem = "Dados cadastrado com sucesso!";
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
  <title>Cadastro de Cliente</title>
  <link rel="stylesheet" href="css/cadastrox_cliente.css">  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
</head>

<body>
  <div class="container">
    <h1>Cadastro de Cliente</h1>
    <?php if (isset($erro)) { ?>
      <p style="color: red;"><?php echo $erro; ?></p>
    <?php } elseif (isset($mensagem)) { ?>
      <p style="color: green;"><?php echo $mensagem; ?></p>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required><br><br>

      <label for="cpf">CPF:</label>
      <input type="text" id="cpf" name="cpf" required oninput="this.value = formatarCPF(this.value)"><br><br>

      <label for="cep">CEP:</label>
      <input type="text" id="cep" name="cep" required>
      <button type="button" id="buscar-cep" onclick="pesquisacep(document.getElementById('cep').value)">Buscar
        CEP</button><br><br>

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
      <input type="text" id="telefone" name="telefone" required
        oninput="this.value = formatarTelefone(this.value)"><br><br>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required oninput="this.value = formatarEmail(this.value)"><br><br>
      <div class="button-container">
        <input type="submit" value="Cadastrar">
        <input type="reset" value="Limpar" onclick="this.form.reset(); return false;">
        <button type="button" id="voltar"><a href="menu.php">Voltar</a></button>
      </div>
    </form>
  </div>
  <script src="js/cadastro_cliente.js"></script>
</body>

</html>