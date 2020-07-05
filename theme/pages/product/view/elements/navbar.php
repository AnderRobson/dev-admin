<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php echo empty($urlProduto) ? "disabled" : ""; echo $active == "product" ? "active" : ""; ?>"
           href="<?= url("pages/product/{$urlProduto}"); ?>">Produto</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($urlStock) ? "disabled" : ""; echo $active == "stock" ? "active" : ""; ?>"
           href="<?= url("pages/stock?product_id={$urlStock}"); ?>">Estoque</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($urlValue) ? "disabled" : ""; echo $active == "value" ? "active" : ""; ?>"
           href="<?= url("pages/value/{$urlValue}"); ?>">Valores</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($urlLink) ? "disabled" : ""; echo $active == "link" ? "active" : ""; ?>"
           href="#">Link</a>
    </li>
</ul>
