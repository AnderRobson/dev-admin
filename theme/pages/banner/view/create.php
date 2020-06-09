<?php
$v->layout("banner/view/_theme", ["title" => "Cadastrando Banner"]); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Cadastrando Banner</h1>
        </div>
        <form action="<?= url("/pages/banner/create"); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleFormControlInput1">Título</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" maxlength="100" name="title" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descrição</label>
                <textarea class="form-control" id="textbanner" rows="3" maxlength="250" name="description" required></textarea>
            </div>
            <script>
                CKEDITOR.replace('textbanner');
            </script>

            <input type="file" id="btnupload" name="file" class="btn btn-success float-left">

            <button type="submit" class="btn btn-success float-right">Salvar Banner</button>
        </form>
    </main>
<?php $v->start("js"); ?>

<?php  $v->end(); ?>
<?php $v->start("css"); ?>
    <?= css('style'); ?>
<?php $v->end(); ?>
