<div class="card">
    <img src="<?= urlFile("product" . DS . $productImage->image); ?>" class="card-img-top" alt="<?= $altImage; ?>">
    <div class="card-footer">
        <small class="text-muted">Imagem cadastrado em: <?= $productImage->created_at; ?></small>
        <a href="#" data-action="<?= url("pages/product-image/delete"); ?>" data-id="<?= $productImage->id; ?>">
            <button type="button" class="btn btn-danger float-right">
                Deletar Imagem
            </button>
        </a>
    </div>
</div>