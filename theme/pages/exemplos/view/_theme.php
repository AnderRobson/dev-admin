<?php
$v->layout("painel/view/_theme", ["title" => $title]); ?>

        <div class="ajax_load">
            <div class="ajax_load_box">
                <div class="ajax_load_box_circle"></div>
                <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
            </div>
        </div>

        <main class="content">
            <?= $v->section("content"); ?>
        </main>

<?php $v->start("js"); ?>
    <?= $v->section("js"); ?>
<?php  $v->end(); ?>
<?php $v->start("css"); ?>
    <?= $v->section("css"); ?>
<?php  $v->end(); ?>