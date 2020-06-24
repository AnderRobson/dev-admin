<?php
$v->layout("login/view/_theme", ["title" => "Cadastro"]); ?>

    <div class="card-body">
        <form method="POST" action="<?= url("registrar"); ?>">
            <div class="form-group row">
<!--                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>-->

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" placeholder="Nome" name="name" required autocomplete="name" autofocus>

<!--                    @error('name')-->
<!--                    <span class="invalid-feedback" role="alert">-->
<!--                            <strong>{{ $message }}</strong>-->
<!--                        </span>-->
<!--                    @enderror-->
                </div>
            </div>

            <div class="form-group row">
<!--                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" placeholder="E-mail" name="email" required autocomplete="email">

<!--                    @error('email')-->
<!--                    <span class="invalid-feedback" role="alert">-->
<!--                            <strong>{{ $message }}</strong>-->
<!--                        </span>-->
<!--                    @enderror-->
                </div>
            </div>

            <div class="form-group row">
<!--                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->

                <div class="col-md-12">
                    <input id="password" type="password" class="form-control" placeholder="Senha" name="password" required autocomplete="new-password">

<!--                    @error('password')-->
<!--                    <span class="invalid-feedback" role="alert">-->
<!--                            <strong>{{ $message }}</strong>-->
<!--                        </span>-->
<!--                    @enderror-->
                </div>
            </div>

            <div class="form-group row">
<!--                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>-->

                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" placeholder="Confirme a senha" name="password_confirmation" required autocomplete="new-password">
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
<?php $v->start("js"); ?>

<?php  $v->end(); ?>
<?php $v->start("css"); ?>
    <?= css("style") ?>
<?php  $v->end(); ?>