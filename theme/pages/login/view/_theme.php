<!doctype html>
<html lang="<?= SITE["LOCALE"] ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= $head; ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <?php
            echo bootstrap("dist/css/bootstrap.min.css");
            echo css("style.min");
            echo js("form");
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