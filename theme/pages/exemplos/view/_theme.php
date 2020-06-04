<?php
$v->layout("painel/view/_theme", ["title" => "Banner"]); ?>

        <div class="ajax_load">
            <div class="ajax_load_box">
                <div class="ajax_load_box_circle"></div>
                <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
            </div>
        </div>

        <main class="content">
            <?= $v->section("content"); ?>
        </main>

        <?= $v->section("js"); ?>

<?php $v->start("css"); ?>
    <?=  getFile(ROOT . DS .'theme/assets/css/style.css'); ?>
<?php  $v->end(); ?>