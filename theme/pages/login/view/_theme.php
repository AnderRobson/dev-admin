<!doctype html>
<html lang="<?= SITE["LOCALE"] ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php
            echo $head;
            echo plugins("bootstrap/dist/css/bootstrap.min.css");
            echo plugins("bootstrap/dist/css/bootstrap-reboot.min.css");
            echo css("style.min");
            echo js("form");
            echo js("jquery");
            $v->section("css");
        ?>
    </head>
    <body>
    <div id="app">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow navbar-expand-md">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= URL_BLOG; ?>"><?= SITE["SHORT_NAME"] ?></a>

            <ul class="navbar-nav px-3 ml-auto">
                <li class="nav-item">
                    <?php if (strtolower($title) != "login"): ?>
                        <a class="nav-link" href="<?= url("login"); ?>">Login</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= url("register"); ?>">Registrar-se</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>

        <main class="py-4" style="margin-top: 10%">
            <div class="ajax_load">
                <div class="ajax_load_box">
                    <div class="ajax_load_box_circle"></div>
                    <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card border-primary">
                            <div class="card-header"><?= $title; ?></div>
                            <div class="form_ajax" style="display: none"></div>
                            <div class="text-center mb-4">
                                <img class="mb-4 m-4" src="<?= urlFile("images/logo.png", true); ?>" alt="Icone da empresa/loja" width="150" height="90">
                            </div>

                            <?= $v->section("content"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?= $v->section("js"); ?>
    </body>
</html>