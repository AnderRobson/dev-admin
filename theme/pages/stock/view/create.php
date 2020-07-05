<?php
$v->layout("stock/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
            $v->insert("product/view/elements/navbar", [
                'urlProduto' => "edit/" . $product->slug,
                "urlStock" => $product->id,
                "active" => "stock"
            ]);
        ?>
        <form method="post" action="<?= url("pages/stock/create/" . $product->slug); ?>" enctype="multipart/form-data">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Cadastrando Estoque</h1>
                <div class="form-group text-center">
                    <h6 for="exampleFormControlInput1">Status do Estoque: </h6>
                    <select name="status" class="custom-select">
                        <option value="0">Desativado</option>
                        <option value="1" selected="selected">Ativado</option>
                    </select>
                </div>
            </div>
            <div class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
                </div>
            </div>
            <div class="form_ajax" style="display: none"></div>
            <?= flash(); ?>
            <div class="form-group">
                <label for="exampleFormControlInput1 ">Título</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" maxlength="100" name="title" required>
            </div>

            <div class="form-group my-3">
                <label for="exampleFormControlTextarea1">Descrição</label>
                <textarea class="form-control" id="description" rows="3" maxlength="250" name="description"></textarea>
            </div>
            <script>
                CKEDITOR.replace('description');
            </script>
            <div class="form-row mb-3">
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Preço antigo</label>
                    <input type="text" class="form-control" maxlength="100" name="old_value" placeholder="Preço antigo">
                </div>
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Preço atual</label>
                    <input type="text" class="form-control" maxlength="100" name="current_value" placeholder="Preço atual" required>
                </div>
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Quantidade em estoque</label>
                    <input type="text" class="form-control" maxlength="11" name="stock" placeholder="Quantidade em estoque" required>
                </div>
                <div class="col-3">
                    <label for="exampleFormControlInput1 ">Código do Estoque</label>
                    <input type="text" class="form-control" maxlength="100" name="code" placeholder="Código de identificação" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right ml-3 my-5">Salvar Produto</button>
            <a href="<?= url("pages/stock?product_id=" . $product->id); ?>">
                <button type="button" class="btn btn-danger float-right my-5">
                    Cancelar
                </button>
            </a>
        </form>
    </main>
<?php $v->start("js"); ?>
    <?= js("form"); ?>
<?php $v->end(); ?>