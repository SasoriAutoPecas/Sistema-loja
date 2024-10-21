<?php
$caminho = "cadastros/usuario.txt";
if (file_exists($caminho)) {
  $usuarios = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
  $usuarios = array();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de Usuários</title>
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
    <h1>Consulta de Usuários</h1>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>CEP</th>
          <th>Rua</th>
          <th>Número</th>
          <th>Complemento</th>
          <th>Bairro</th>
          <th>Cidade</th>
          <th>UF</th>
          <th>Telefone</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario) { ?>
          <?php $dados_usuario = explode(", ", $usuario); ?>
          <tr>
            <td><?= $dados_usuario[3] ?></td>
            <td><?= $dados_usuario[1] ?></td>
            <td><?= $dados_usuario[4] ?></td>
            <td><?= $dados_usuario[5] ?></td>
            <td><?= $dados_usuario[6] ?></td>
            <td><?= $dados_usuario[7] ?></td>
            <td><?= $dados_usuario[8] ?></td>
            <td><?= $dados_usuario[9] ?></td>
            <td><?= $dados_usuario[10] ?></td>
            <td><?= $dados_usuario[11] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p><a href="menu.php" class="btn-voltar">Voltar</a></p>
  </div>
</body>
</html>