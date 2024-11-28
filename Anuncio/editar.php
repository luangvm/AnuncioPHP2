<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $arquivo = $_POST['arquivo']; 
    $imagem = $_FILES['imagem'];
    $data = date('Y-m-d');

    if ($imagem['error'] === 0) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nome_imagem = uniqid() . '.' . $extensao;
        $caminho_imagem = 'images/' . $nome_imagem;

        move_uploaded_file($imagem['tmp_name'], $caminho_imagem);
    } else {

        $conteudo = file_get_contents("anuncios/{$arquivo}");
        $linhas = explode("\n", $conteudo);
        $nome_imagem = $linhas[3];
    }

    $novo_conteudo = "{$titulo}\n{$descricao}\n{$data}\n{$nome_imagem}";
    file_put_contents("anuncios/{$arquivo}", $novo_conteudo);

    echo "<div class='alert alert-success'>Anúncio editado com sucesso!</div>";
}

if (isset($_GET['arquivo'])) {
    $arquivo = $_GET['arquivo'];
    $conteudo = file_get_contents("anuncios/{$arquivo}");
    $linhas = explode("\n", $conteudo);
    $titulo = $linhas[0];
    $descricao = $linhas[1];
    $imagem = $linhas[3];
} else {
    die("Anúncio não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Anúncio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Editar Anúncio</h1>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="arquivo" value="<?= $arquivo ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $titulo ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" required><?= $descricao ?></textarea>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem de Capa</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                <?php if ($imagem): ?>
                    <p>Imagem atual: <img src="images/<?= $imagem ?>" alt="Imagem do anúncio" style="max-width: 100px;"></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>
