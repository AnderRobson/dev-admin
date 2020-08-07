<?php
$v->layout("stock/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
            $v->insert("product/view/elements/navbar", [
                'productUrl' => "edit/" . $product->slug,
                "productId" => $product->id,
                "active" => "stock"
            ]);
        ?>
        <form method="post" action="<?= url("pages/stock/edit/" . $stock->slug); ?>" enctype="multipart/form-data">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Editando Estoque</h1>
                <div class="form-group text-center">
                    <h6 for="exampleFormControlInput1">Status do Estoque: </h6>
                    <select name="status" class="custom-select">
                        <option value="0" <?= ! $stock->status? "selected='selected'": ""?> >Desativado</option>
                        <option value="1" <?= $stock->status? "selected='selected'": ""?> >Ativado</option>
                    </select>
                </div>
            </div>
            <?= flash(); ?>
            <div class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
                </div>
            </div>
            <div class="form_ajax" style="display: none"></div>
            <input type="text" class="form-control" maxlength="100" value="<?= $stock->id ?>" name="id"  hidden required>
            <div class="form-group">
                <label for="exampleFormControlInput1 ">Título</label>
                <input type="text" class="form-control"exampleFormControlInput1 maxlength="100" value="<?= $stock->title ?>" name="title" required>
            </div>

            <div class="form-group my-3">
                <label for="exampleFormControlTextarea1">Descrição</label>
                <textarea class="form-control" id="description" rows="3" maxlength="250" name="description" required>
                    <?= $stock->description; ?>
                </textarea>
            </div>
            <script>
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .catch( error => {
                        console.error( error );
                    } );
            </script>
            <div class="form-row mb-3">
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Preço antigo</label>
                    <input type="text" class="form-control" maxlength="100" value="<?= $stock->old_value ?>" name="old_value" placeholder="Preço antigo">
                </div>
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Preço atual</label>
                    <input type="text" class="form-control" maxlength="100" value="<?= $stock->current_value ?>" name="current_value" placeholder="Preço atual" required>
                </div>
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Quantidade em estoque</label>
                    <input type="text" class="form-control" maxlength="11" value="<?= $stock->stock ?>" name="stock" placeholder="Quantidade em estoque" required>
                </div>
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Código do Estoque</label>
                    <input type="text" class="form-control" maxlength="100" value="<?= $stock->code ?>" name="code" placeholder="Código de identificação" required>
                </div>
            </div>
            <div class="form-group">
                <p>Produto cadastrado em: <?= $stock->created_at; ?></p>
            </div>
            <button type="submit" class="btn btn-success float-right ml-3 my-5">Salvar Estoque</button>
            <a href="<?= url("pages/stock?product_id=" . $product->id); ?>">
                <button type="button" class="btn btn-danger float-right my-5">
                    Cancelar
                </button>
            </a>
        </form>
    </main>
<?php
    $v->start("js");
        echo js("form");
    $v->end();
