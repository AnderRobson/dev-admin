<!doctype html>
<html lang="<?= SITE["LOCALE"] ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?= $head; ?>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
        <?php
            echo bootstrap("dist/css/bootstrap.min.css");
            echo css("style.min");
            echo $v->section("css");
        ?>
    </head>
    <body>
        <?php
            $v->insert("painel/view/elements/navbar");
            $v->insert("painel/view/elements/menu");
        ?>

        <div class="container-fluid">
            <?= $v->section("content"); ?>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

        <!-- Responsavel por carregar os icones -->
        <script>
            feather.replace();
        </script>

        <?php
            echo js("admin");
            echo bootstrap("dist/js/bootstrap.bundle.min.js");
            echo $v->section("js");
        ?>
    </body>
</html>