<?php
$v->layout("login/view/_theme", ["title" => "Login"]); ?>

    <div class="card-body">
        <form method="POST" action="<?= url("login"); ?>">
            <div class="form-group row">
<!--                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" placeholder="E-mail" name="email" required autocomplete="email" autofocus>

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
                    <input id="password" type="password" class="form-control" placeholder="Senha" name="password" required autocomplete="current-password">

<!--                    @error('password')-->
<!--                    <span class="invalid-feedback" role="alert">-->
<!--                            <strong>{{ $message }}</strong>-->
<!--                        </span>-->
<!--                    @enderror-->
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-check">
<!--                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>-->

<!--                        <label class="form-check-label" for="remember">-->
<!--                            {{ __('Remember Me') }}-->
<!--                        </label>-->

<!--                        @if (Route::has('password.request'))-->
<!--                        <a class="btn btn-link  offset-md-2" href="{{ route('password.request') }}">-->
<!--                            {{ __('Forgot Your Password?') }}-->
<!--                        </a>-->
<!--                        @endif-->
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-2">
                    <button type="submit" class="btn btn-lg btn-outline-primary btn-block">
                        Logar-se
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