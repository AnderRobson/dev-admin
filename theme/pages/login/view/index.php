<?php
$v->layout("login/view/_theme", ["title" => "Login"]); ?>

    <div class="card-body">
        <form method="POST" action="<?= url("login"); ?>">
            <?= flash(); ?>

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" placeholder="E-mail" name="email" required autocomplete="email" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control" placeholder="Senha" name="password" required autocomplete="current-password">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-0">
                    <a href="<?= url("forget"); ?>" >
                        Recuperar Senha
                    </a>
                </div>
                <div class="col-md-4 offset-md-0">
                    <button type="submit" class="btn btn-lg btn-outline-primary btn-block">
                        Logar-se
                    </button>
                </div>
            </div>
            <div class="div-redesocial">
                <a href="<?= url("facebook"); ?>">
                    <button type="button" class="btn btn-lg btn-primary btn-facebook">
                            Facebook
                    </button>
                </a>
                <a href="<?= url("google"); ?>">
                    <button type="button" class="btn btn-lg btn-danger btn-google">
                            Google
                    </button>
                </a>
            </div>
        </form>
    </div>