<?php
$v->layout("productImage/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
            $v->insert("product/view/elements/navbar", [
                'productUrl' => "edit/" . $product->slug,
                "productId" => $product->id,
                "active" => "image"
            ]);
        ?>
        <form method="post" action="<?= url("pages/product-image/create/" . $product->slug); ?>" enctype="multipart/form-data">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Cadastrando Imagem</h1>
            </div>
            <?= flash(); ?>
            <div class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
                </div>
            </div>
            <div class="form_ajax" style="display: none"></div>
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <div id="imgLocal">
                        <img src="<?= urlFile('product/semimage.png')?>" class="rounded img-fluid" id="preview" alt="...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input id="inputImage" type="file" name="file" onchange="pegaArquivo(this.files)" class="btn btn-success float-left my-5">
                    <button type="submit" class="btn btn-success float-right ml-3 my-5">Salvar Produto</button>
                    <a href="<?= url("pages/stock?product_id=" . $product->id); ?>">
                        <button type="button" class="btn btn-danger float-right my-5">
                            Cancelar
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </main>
<?php $v->start("js"); ?>
    <script>
        function pegaArquivo(files) {
            let imgLoca = document.getElementById('imgLocal');
            let file = files[0];
            let img = document.createElement("img");
            let preview = document.getElementById("preview");
            img.file = file;

            imgLocal.appendChild(img)

            let reader = new FileReader();
            reader.onload = (function (aImg) {
                    return function (e) {
                        aImg.src = e.target.result;
                        aImg.className = 'rounded img-fluid';
                        aImg.id = 'preview';
                    };
                }
            )(img);

            preview.remove();
            reader.readAsDataURL(file);
        }
    </script>
<?php $v->end(); ?>