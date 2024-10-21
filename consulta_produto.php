<?php
$caminho = "cadastros/produto.txt";
if (file_exists($caminho)) {
  $produtos = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
  $produtos = array();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de Produtos</title>
  <link rel="stylesheet" href="css/consulta.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="img/Logo_site.png">
</head>

<body>
  <div class="container">
    <h1>Consulta de Produtos</h1>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Categoria</th>
          <th>Preço</th>
          <th>Estoque</th>
          <th>Peso</th>
          <th>Dimensão</th>
          <th>Fabricante</th> 
          <th>Validade</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produtos as $produto) { ?>
          <?php $dados_produto = explode(", ", $produto); ?>
          <tr>
            <td><?= $dados_produto[1] ?></td>
            <td><?= $dados_produto[2] ?></td>
            <td><?= $dados_produto[3] ?></td>
            <td><?= $dados_produto[4] ?></td>
            <td><?= $dados_produto[5] ?></td>
            <td><?= $dados_produto[6] ?></td>
            <td><?= $dados_produto[7] ?></td>
            <td><?= $dados_produto[8] ?></td>
            <td><?= $dados_produto[9] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p><a href="menu.php" class="btn-voltar">Voltar</a></p>
  </div>
</body>
</html>