<?php
$v->layout("painel/view/_theme", ["title" => $title]); ?>
    <div class="container-fluid">
        <?= $v->section("content"); ?>
    </div>
<?php $v->start("js"); ?>
    <?= $v->section("js"); ?>
<?php  $v->end(); ?>
<?php $v->start("cs"); ?>
    <?= $v->section("cs"); ?>
<?php  $v->end(); ?>
