<?php
$v->layout("login/view/_theme", ["title" => "Criando nova senha"]); ?>

    <div class="card-body">
        <form method="POST" action="<?= url("reset"); ?>">
            <?= flash(); ?>
            <div class="form-group row">
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control" placeholder="Cadastrar uma nova senha" name="password" required autocomplete="new-password" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control" placeholder="Repita sua nova senha" name="password_confirmation" required autocomplete="current-password">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-2">
                    <button type="submit" class="btn btn-lg btn-outline-primary btn-block">
                        Atualizar minha senha
                    </button>
                </div>
            </div>
        </form>
    </div>