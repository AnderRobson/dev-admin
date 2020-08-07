<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php echo empty($productUrl) ? "disabled" : ""; echo $active == "product" ? "active" : ""; ?>"
           href="<?= url("pages/product/{$productUrl}"); ?>">Produto</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($productId) ? "disabled" : ""; echo $active == "stock" ? "active" : ""; ?>"
           href="<?= url("pages/stock?product_id={$productId}"); ?>">Estoque</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($urlValue) ? "disabled" : ""; echo $active == "value" ? "active" : ""; ?>"
           href="<?= url("pages/value/{$urlValue}"); ?>">Valores</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($productId) ? "disabled" : ""; echo $active == "image" ? "active" : ""; ?>"
           href="<?= url("pages/product-image?product_id={$productId}"); ?>">Imagens</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo empty($urlLink) ? "disabled" : ""; echo $active == "link" ? "active" : ""; ?>"
           href="#">Link</a>
    </li>
</ul>
