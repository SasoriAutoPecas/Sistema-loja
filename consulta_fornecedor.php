<?php
$caminho = "cadastros/fornecedor.txt";
if (file_exists($caminho)) {
  $fornecedores = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
  $fornecedores = array();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de Fornecedores</title>
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
    <h1>Consulta de Fornecedores</h1>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>CNPJ</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>CEP</th>
          <th>Rua</th>
          <th>Nº</th>
          <th>Complemento</th>
          <th>Bairro</th>
          <th>Cidade</th>
          <th>UF</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($fornecedores as $fornecedor) { ?>
          <?php $dados_fornecedor = explode(", ", $fornecedor); ?>
          <tr>
            <td><?= $dados_fornecedor[4] ?></td>
            <td><?= $dados_fornecedor[1] ?></td>
            <td><?= $dados_fornecedor[12] ?></td>
            <td><?= $dados_fornecedor[11] ?></td>
            <td><?= $dados_fornecedor[3] ?></td>
            <td><?= $dados_fornecedor[5] ?></td>
            <td><?= $dados_fornecedor[6] ?></td>
            <td><?= $dados_fornecedor[7] ?></td>
            <td><?= $dados_fornecedor[8] ?></td>
            <td><?= $dados_fornecedor[9] ?></td>
            <td><?= $dados_fornecedor[10] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p><a href="menu.php" class="btn-voltar">Voltar</a></p>
  </div>
</body>
</html>