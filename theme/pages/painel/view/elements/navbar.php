<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow navbar-expand-md">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?= SITE["SHORT_NAME"] ?></a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3 ml-auto">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <?= $user->person->first_name . " " . $user->person->last_name;?> <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" >
                <a class="dropdown-item" href="<?= url("pages/user"); ?>"> Perfil </a>
                <a class="dropdown-item" href="<?= url("sair"); ?>"> Sair </a>
            </div>
        </li>
    </ul>
</nav>