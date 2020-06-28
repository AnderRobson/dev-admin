<?php
$v->layout("login/view/_theme", ["title" => "Recuperar senha"]); ?>

    <div class="card-body">
        <form method="POST" action="<?= url("forget"); ?>">
            <?= flash(); ?>
            <div class="form-group row">
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" placeholder="E-mail" name="email" autocomplete="email" autofocus>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 offset-md-0">
                    <button type="submit" class="btn btn-lg btn-outline-primary btn-block">
                        Recuperar minha senha
                    </button>
                </div>
            </div>
        </form>
    </div>