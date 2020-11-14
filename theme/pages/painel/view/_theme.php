<!doctype html>
<html lang="<?= SITE["LOCALE"] ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <?php
            echo $head;
            echo js("jquery");
            echo js("utilities");
            echo plugins("bootstrap/dist/css/bootstrap.min.css");
            echo plugins("bootstrap/dist/css/bootstrap-reboot.min.css");
            echo plugins("ckeditor5-build-classic/ckeditor.js");
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
        <?php
            echo plugins("chartjs/dist/js/Chart.bundle.js");
            echo plugins("feather-icons/feather.min.js");
            echo js("style.min");
            echo plugins("bootstrap/dist/js/bootstrap.bundle.min.js");
            echo $v->section("js");
        ?>
        <!-- Responsavel por carregar os icones -->
        <script>
            feather.replace();
        </script>
    </body>
</html>