<?php
if (isset($_GET['arquivo'])) {
    $arquivo = $_GET['arquivo'];
    
    if (file_exists("anuncios/{$arquivo}")) {
        unlink("anuncios/{$arquivo}");
        echo "<div class='alert alert-success'>Anúncio excluído com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Anúncio não encontrado.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Erro: anúncio não especificado.</div>";
}
?>

<a href="index.php" class="btn btn-primary">Voltar para a página principal</a>
