<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];
    $data = date('Y-m-d');

    if ($imagem['error'] === 0) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nome_imagem = uniqid() . '.' . $extensao;
        $caminho_imagem = 'images/' . $nome_imagem;

        move_uploaded_file($imagem['tmp_name'], $caminho_imagem);

        $nome_arquivo = 'anuncios/' . uniqid() . '.txt';
        $conteudo = "{$titulo}\n{$descricao}\n{$data}\n{$nome_imagem}";
        file_put_contents($nome_arquivo, $conteudo);

        echo "<div class='alert alert-success'>Anúncio '$titulo' adicionado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao enviar a imagem. Tente novamente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Anúncio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Adicionar Novo Anúncio</h1>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem de Capa</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Anúncio</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>
