<?php
$v->layout("painel/view/_theme"); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <?php
        $v->insert("home/view/elements/dashbord");
        $v->insert("home/view/elements/table");
    ?>
</main>
