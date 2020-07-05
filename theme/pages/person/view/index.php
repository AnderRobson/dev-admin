<?php
//printrx($states);
$v->layout("person/view/_theme"); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
        </div>
    </div>
    <div class="form_ajax" style="display: none"></div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pessoas Cadastradas</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= url("pages/person/create"); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                <span data-feather="plus"></span>
                Cadastrar Pessoa
            </a>
        </div>
    </div>
    <form method="post" class="mb-5" action="<?= url("pages/person/index"); ?>">
        <div class="form-row">
            <div class="col-3 mb-1">
                <input type="text" name="first_name" class="form-control" placeholder="Nome">
            </div>
            <div class="col-3 mb-1">
                <input type="text" name="last_name" class="form-control" placeholder="Sobrenome">
            </div>
            <div class="col-3 mb-1">
                <input type="text" name="cpf_cnpj" class="form-control" placeholder="CPF/CNPJ">
            </div>
            <div class="col-3 mb-1">
                <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" autocomplete="email">
            </div>
            <div class="col-3 mb-1">
                <input type="text" name="city" class="form-control" placeholder="Cidade">
            </div>
            <div class="form-group col-md-3 mb-1">
                <select name="state" id="inputState" class="form-control">
                    <option value="0">Estado</option>
                    <?php foreach ($states as $state): ?>
                        <option value="<?= $state->id; ?>"><?= $state->initials; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-3 mb-1">
                <input type="text" name="zip" class="form-control" placeholder="CEP">
            </div>
            <div class="col-3 mb-1">
                <input type="date" name="date_birth" class="form-control" placeholder="Data aniversário">
            </div>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0 mt-2">
            <button type="submit" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                <span data-feather="filter"></span>
                Filtrar
            </button>
        </div>
<!--        <div class="col-md-4 offset-md-0">-->
<!--            <button type="submit" class="btn btn-lg btn-outline-primary btn-block">-->
<!--                Logar-se-->
<!--            </button>-->
<!--        </div>-->
    </form>
    <table class="table text-center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Data de aniversário</th>
            <th scope="col">Descrição</th>
            <th scope="col">Opções</th>
        </tr>
        </thead>
        <tbody>
            <?php if (! empty($persons)):
                foreach ($persons as $person):
                    $v->insert("person/view/elements/table", ['person' => $person]);
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
