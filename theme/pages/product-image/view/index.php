<?php
$v->layout("product-image/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
            $v->insert("product/view/elements/navbar", [
                'productUrl' => "edit/" . $product->slug,
                "productId" => $product->id,
                "active" => "image"
            ]);
        ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4">Imagens do produto <?= $product->title; ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="<?= url("pages/product-image/create/" . $product->slug); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                    <span data-feather="plus"></span>
                    Cadastrar Imagens
                </a>
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
        <div class="card-deck">
            <?php
                if (! empty($productImages)):
                    foreach ($productImages as $productImage):
                        $v->insert(
                                "product-image/view/elements/cardImage",
                                [
                                    'productImage' => $productImage,
                                    'altImage' => $product->title
                                ]);
                    endforeach;
                endif;
            ?>
        </div>
    </main>
<?php $v->start("js"); ?>
    <script>
        $(function () {
            function load(action) {
                var load_div = $(".ajax_load");
                if (action === "open") {
                    load_div.fadeIn().css("display", "flex");
                } else {
                    load_div.fadeOut();
                }
            }

            load("close");

            $("body").on("click", "[data-action]", function (e) {
                e.preventDefault();

                load("open");

                var data = $(this).data();
                var div = $(this).parent().parent();

                $.post(data.action, data, function () {
                    load('close');
                    div.fadeOut();
                }, "json").fail(function () {
                    load('close');
                    alert("Erro ao processar a requisição !");
                })
            })
        });
    </script>
<?php
$v->end();
$v->start("css");
$v->end();
