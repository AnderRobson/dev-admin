<?php
$v->layout("painel/view/_theme"); ?>

<div class="container-fluid">
    <?= $v->section("content"); ?>
</div>

<?php $v->start("js"); ?>
    <?= $v->section("js"); ?>
<?php  $v->end(); ?>
<?php $v->start("css"); ?>
    <?= $v->section("css"); ?>
<?php  $v->end(); ?>
