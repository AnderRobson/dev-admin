<?php
$v->layout("painel/view/_theme"); ?>
<div class="container-fluid">
        <?= $v->section("content"); ?>
    </div>
<?php
$v->start("js");
    echo $v->section("js");
$v->end();
$v->start("cs");
    echo $v->section("cs");
$v->end();
