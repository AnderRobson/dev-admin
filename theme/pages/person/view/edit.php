<?php
$v->layout("publication/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Editando Banner</h1>
        </div>
        <form method="post" action="<?= url("pages/publication/edit/" . $publication->slug); ?>"  enctype="multipart/form-data">
            <div class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
                </div>
            </div>
            <div class="form_ajax" style="display: none"></div>
            <input type="text" class="form-control" id="exampleFormControlInput1" maxlength="100" value="<?= $publication->id ?>" name="id"  hidden required>
            <div class="form-group">
                <label for="exampleFormControlInput1">Título</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" maxlength="100" value="<?= $publication->title ?>" name="title" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descrição</label>
                <textarea class="form-control" id="textpublication" rows="3" maxlength="250" name="description" required>
                    <?= $publication->description ?>
                </textarea>
            </div>
            <script>
                CKEDITOR.replace('textpublication');
            </script>

            <input type="file" id="btnupload" name="file" class="btn btn-success float-left">

            <button type="submit" class="btn btn-success float-right ml-3">Salvar Banner</button>
            <a href="<?= url("pages/publication"); ?>">
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
