<?php
$v->layout("user/view/_theme"); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <section class="row box">
        <article class="col-12 box-top-profile">
            <img src="<?= $user->photo; ?>" class="img-thumbnail block" alt="<?= $user->person->first_name . " " . $user->person->last_name;?>">
            <div id="menu" class="float-right">
                    <h2 class="float-left"><?= $user->person->first_name . " " . $user->person->last_name;?></h2>
            </div>
        </article>
    </section>
    <section class="row box">

    </section>
</main>
<?php
    $v->start("css");
        echo css("profile");
    $v->end();
