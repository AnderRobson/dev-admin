<?php
$v->layout("painel/view/_theme", ["title" => $title]); ?>

<div class="container-fluid">
    <?= $v->section("content"); ?>
</div>