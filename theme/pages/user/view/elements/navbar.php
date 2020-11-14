<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?= $page == "perfil" ? "active" : ""; ?>"
           href="<?= url("pages/user"); ?>">Perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($productId) ? "disabled" : ""; echo $active == "stock" ? "active" : ""; ?>"
           href="<?= url("pages/stock?product_id={$productId}"); ?>">Seus Pedidos</a>
    </li>
</ul>
