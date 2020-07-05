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
        <div class="ajax_load">
            <div class="ajax_load_box">
                <div class="ajax_load_box_circle"></div>
                <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
            </div>
        </div>
        <div class="form_ajax" style="display: none"></div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4">Estoques do produto <?= $product->title; ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="<?= url("pages/stock/create/" . $product->slug); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                    <span data-feather="plus"></span>
                    Cadastrar Estoque
                </a>
            </div>
        </div>
        <?= flash(); ?>
        <table class="table text-center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Título</th>
                <th scope="col">Descrição</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Preço Antigo</th>
                <th scope="col">Preço Atual</th>
                <th scope="col">Status</th>
                <th scope="col">Opções</th>
            </tr>
            </thead>
            <tbody>
                <section class="product">
                    <?php
                        if (! empty($stock)):
                            foreach ($stock as $stock):
                                $v->insert("stock/view/elements/stock", ['stock' => $stock]);
                            endforeach;
                        endif;
                    ?>
                </section>
            </tbody>
        </table>
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
