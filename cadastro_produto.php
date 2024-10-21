<?php
if (!empty($_POST)) {
  $caminho = "cadastros/produto.txt";
  $produtos = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $codigo_ja_cadastrado = false;
  $nome_ja_cadastrado = false;

  foreach ($produtos as $produto) {
    $dados_produto = explode(", ", $produto);
    if ($dados_produto[0] == $_POST['codigo_produto']) {
      $codigo_ja_cadastrado = true;
    }
    if ($dados_produto[1] == $_POST['nome_produto']) {
      $nome_ja_cadastrado = true;
    }
  }

  if ($codigo_ja_cadastrado) {
    $erro = "Código de produto já cadastrado!";
  } elseif ($nome_ja_cadastrado) {
    $erro = "Nome de produto já cadastrado!";
  } else {
    $produto = array(
      $_POST['codigo_produto'],
      $_POST['nome_produto'],
      $_POST['descricao_produto'],
      $_POST['categoria_produto'],
      $_POST['preco_produto'],
      $_POST['quantidade_estoque'],
      $_POST['peso_produto'],
      $_POST['dimensoes_produto'],
      $_POST['fabricante_produto'],
      $_POST['data_validade']
    );

    $conteudo = "";

    foreach ($produto as $dados) {
      $conteudo .= $dados . ", ";
    }

    $conteudo .= "\n";

    if (file_put_contents($caminho, $conteudo, FILE_APPEND)) {
      $mensagem = "Produto cadastrado com sucesso!";
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
  <title>Cadastro de Produto</title>
  <link rel="stylesheet" href="css/cadastrox.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
</head>
<body>
  <div class="container">
    <h1>Cadastro de Produto</h1>
    <?php if (isset($erro)) { ?>
      <p style="color: red;"><?php echo $erro; ?></p>
    <?php } elseif (isset($mensagem)) { ?>
      <p style="color: green;"><?php echo $mensagem;?></p>
    <?php }?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label for="nome_produto">Nome do Produto:</label>
      <input type="text" id="nome_produto" name="nome_produto" required><br><br>

      <label for="descricao_produto">Descrição do Produto:</label>
      <textarea id="descricao_produto" name="descricao_produto" required></textarea><br><br>

      <label for="categoria_produto">Categoria do Produto:</label>
      <select id="categoria_produto" name="categoria_produto" required>
        <option value="">Selecione uma categoria</option>
        <option value="Alimentício">Alimentício</option>
        <option value="Brinquedos">Brinquedos</option>
        <option value="Produtodelimpeza">Produto de limpeza</option>
      </select><br><br>

      <label for="preco_produto">Preço do Produto:</label>
      <input type="number" id="preco_produto" name="preco_produto" required><br><br>

      <label for="quantidade_estoque">Quantidade em Estoque:</label>
      <input type="number" id="quantidade_estoque" name="quantidade_estoque" required><br><br>

      <label for="peso_produto">Peso do Produto:</label>
      <input type="number" id="peso_produto" name="peso_produto" required><br><br>

      <label for="dimensoes_produto">Dimensões do Produto:</label>
      <input type="text" id="dimensoes_produto" name="dimensoes_produto" required><br><br>

      <label for="codigo_produto">Codigo do produto:</label>
      <input type="number" id="codigo_produto" name="codigo-produto" required><br><br>

      <label for="imagem_produto">Imagem do Produto:</label>
      <input type="file" id="imagem_produto" name="imagem_produto"><br><br>

      <label for="fabricante_produto">Fabricante do Produto:</label>
      <input type="text" id="fabricante_produto" name="fabricante_produto" required><br><br>

      <label for="data_validade">Data de Validade:</label>
      <input type="date" id="data_validade" name="data_validade"><br><br>

      <input type="submit" value="Cadastrar">
      <input type="reset" value="Limpar">
      <button type="button" id="voltar"><a href="menu.php">Voltar</a></button>
    </form>
  </div>
  <script src="js/cadastro_produto.js"></script>
</body>
</html>