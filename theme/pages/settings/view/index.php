<?php
$v->layout("settings/view/_theme"); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Configurações</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= url("pages/settings/create"); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                <span data-feather="plus"></span>
                Cadastrar Configuração
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
    <form method="post" class="mb-5" action="<?= url("pages/settings/index"); ?>">
        <div class="form-row">
            <div class="col-md-6 mb-1">
                <input type="text" name="name" class="form-control" placeholder="Nome">
            </div>
            <div class="col-md-4 mb-1">
                <select name="status" id="inputState" class="form-control">
                    <option value="1">Status Ativada</option>
                    <option value="0">Status Desativada</option>
                </select>
            </div>
            <div class="col-md-2 mb-1">
                <button type="submit" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                    <span data-feather="filter"></span>
                    Filtrar
                </button>
            </div>
        </div>
    </form>
    <table class="table text-center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">valor</th>
            <th scope="col">Status</th>
            <th scope="col">Opções</th>
        </tr>
        </thead>
        <tbody>
        <?php if (! empty($configures)):
            foreach ($configures as $configure):
                $v->insert("settings/view/elements/table", ['configure' => $configure]);
            endforeach;
        endif; ?>
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

        load('close');

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
<?php  $v->end(); ?>
