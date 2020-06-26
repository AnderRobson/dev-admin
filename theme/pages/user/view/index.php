<?php
$v->layout("painel/view/_theme"); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="jumbotron jumbotron-fluid">
        <img src="<?= $user->photo; ?>" class="img-thumbnail" alt="<?= $user->first_name . " " . $user->last_name;?>">
        <div class="container float-right">
            <h1 class="display-6"><?= $user->first_name . " " . $user->last_name;?></h1>
            <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
        </div>
    </div>
</main>
