<?php
$v->layout("settings/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <form method="post" action="<?= url("pages/settings/edit/" . $configure->id); ?>"  enctype="multipart/form-data">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Editando Configuração</h1>
                <div class="form-group text-center">
                    <h6>Status da Configure: </h6>
                    <select name="status" class="custom-select">
                        <option value="0" <?= ! $configure->status? "selected='selected'": "";?> >Desativado</option>
                        <option value="1" <?= $configure->status? "selected='selected'": "";?> >Ativado</option>
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
            <input type="text" class="form-control" maxlength="100" value="<?= $configure->id; ?>" name="id"  hidden required>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nome</label>
                <input type="text" class="form-control" maxlength="100" value="<?= $configure->name; ?>" name="name" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Valor: (JSON)</label>
                <textarea class="form-control" id="value" rows="3" maxlength="250" name="value" required>
                    <?= json_encode($configure->value); ?>
                </textarea>
            </div>
            <script>
                ClassicEditor
                    .create(document.querySelector('#value'))
                    .catch( error => {
                        console.error( error );
                    } );
            </script>
            <button type="submit" class="btn btn-success float-right ml-3">Salvar Configuração</button>
            <a href="<?= url("pages/settings"); ?>">
                <button type="button" class="btn btn-danger float-right">
                    Cancelar
                </button>
            </a>
        </form>
    </main>
<?php
$v->start("js");
    echo js("form");
$v->end();
