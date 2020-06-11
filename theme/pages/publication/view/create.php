<?php
$v->layout("banner/view/_theme", ["title" => "Cadastrando Publicação"]); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cadastrando Publicação</h1>
    </div>
    <form action="<?= url("/pages/publication/create"); ?>" method="post"  enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlInput1">Título</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" maxlength="100" name="title">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" id="textdescricao" rows="3" maxlength="250" name="description"></textarea>
        </div>
        <script>
            CKEDITOR.replace('textdescricao');
        </script>

        <input type="file" id="btnupload" name="file" class="btn btn-success float-left">

        <button type="submit" class="btn btn-success float-right">Salvar Publicação</button>
    </form>

</main>

<?php $v->start("js"); ?>

<?php  $v->end(); ?>
<?php $v->start("css"); ?>
    <?= css('style'); ?>
<?php $v->end(); ?>
