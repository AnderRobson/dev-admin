<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url("pages/home"); ?>">
                            <span data-feather="home"></span>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <span data-feather="plus-square"></span>
                            Register
                        </a>

                        <div class="dropdown-menu" >
                            <a class="nav-link" href="<?= url("pages/product"); ?>">
                                <span data-feather="file-plus"></span>
                                Products
                            </a>
                            <a class="nav-link" href="<?= url("pages/banner"); ?>">
                                <span data-feather="image"></span>
                                Banners
                            </a>
                            <a class="nav-link" href="<?= url("pages/publication"); ?>">
                                <span data-feather="book-open"></span>
                                Publication
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url("pages/person"); ?>">
                            <span data-feather="users"></span>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url("pages/order"); ?>">
                            <span data-feather="shopping-bag"></span>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url("pages/settings"); ?>">
                            <span data-feather="settings"></span>
                            Settings
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Year-end sale
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>