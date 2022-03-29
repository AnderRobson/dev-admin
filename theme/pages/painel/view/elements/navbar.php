<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow navbar-expand-md">
    <a class="navbar-brand text-center m-0 col-sm-3 col-md-2 mr-0 h1" href="#">
        <img src="<?= urlFile("images/logo.png", true); ?>" width="35" height="25" class="d-inline-block align-top" alt="">
        <?= SITE["SHORT_NAME"] ?>
    </a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3 ml-auto">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <?= $user->getFullName(); ?> <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" >
                <a class="dropdown-item" href="<?= url("pages/user"); ?>">
                    <span data-feather="user"></span>
                    Perfil
                </a>
                <a class="dropdown-item" href="<?= url("pages/settings"); ?>">
                    <span data-feather="settings"></span>
                    Settings
                </a>
                <a class="dropdown-item" href="<?= url("sair"); ?>">
                    <span data-feather="log-out"></span>
                    Sair
                </a>
            </div>
        </li>
    </ul>
</nav>