<?php
function exibirAnuncios() {
    $anuncios = [];
    $arquivos = scandir('anuncios'); 
    
    foreach ($arquivos as $arquivo) {
        if ($arquivo != '.' && $arquivo != '..') {
            $conteudo = file_get_contents("anuncios/{$arquivo}");
            $linhas = explode("\n", $conteudo);
            $anuncios[] = [
                'titulo' => $linhas[0],
                'descricao' => $linhas[1],
                'data' => $linhas[2],
                'imagem' => $linhas[3],
                'arquivo' => $arquivo, 
            ];
        }
    }
    return $anuncios;
}

$anuncios = exibirAnuncios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Anúncios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Sistema de Anúncios</h1>

        <div class="text-center mb-4">
            <a href="adicionar.php" class="btn btn-primary">Adicionar Novo Anúncio</a>
        </div>

        <?php if (count($anuncios) > 0): ?>
            <div class="row">
                <?php foreach ($anuncios as $anuncio): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="images/<?= $anuncio['imagem'] ?>" class="card-img-top" alt="Imagem do anúncio">
                            <div class="card-body">
                                <h5 class="card-title"><?= $anuncio['titulo'] ?></h5>
                                <p class="card-text"><?= $anuncio['descricao'] ?></p>
                                <small class="text-muted"><?= $anuncio['data'] ?></small>
                                <br><br>
                                <a href="editar.php?arquivo=<?= $anuncio['arquivo'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="excluir.php?arquivo=<?= $anuncio['arquivo'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este anúncio?')">Excluir</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Não há anúncios disponíveis no momento.</div>
        <?php endif; ?>
    </div>
</body>
</html>
