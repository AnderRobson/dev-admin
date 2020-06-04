<?php
$v->layout("banner/view/_theme", ["title" => "Cadastrando Banner"]); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cadastrando Banner</h1>
    </div>
    <form action="<?= url("/pages/banner/create"); ?>" method="post"  enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlInput1">Título</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" maxlength="100" name="title">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="250" name="description"></textarea>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Imagem</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success float-right">Salvar Banner</button>
    </form>
</main>