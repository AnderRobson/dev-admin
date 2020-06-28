<?php
$v->layout("login/view/_theme", ["title" => "Cadastro"]); ?>

    <div class="card-body">
        <form method="POST" action="<?= url("register"); ?>">
            <?= flash(); ?>
            <div class="form-group row">
                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" value="<?= $formUser->first_name; ?>"
                           placeholder="Nome" name="name" required autocomplete="name" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="sobrenome" type="text" class="form-control" value="<?= $formUser->last_name; ?>"
                           placeholder="Sobrenome" name="sobrenome" required autocomplete="sobrenome">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" value="<?= $formUser->email; ?>"
                           placeholder="E-mail" name="email" required autocomplete="email">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control"
                           placeholder="Senha" name="password" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-2">
                    <button type="submit" class="btn btn-lg btn-outline-primary btn-block">
                        Registrar-se
                    </button>
                </div>
            </div>
        </form>
    </div>