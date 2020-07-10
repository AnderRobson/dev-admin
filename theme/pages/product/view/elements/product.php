<tr>
    <td><?= $product->code; ?></td>
    <td><?= $product->title; ?></td>
    <td><?= substr($product->description, 0, 60); ?></td>
    <td><?= $product->status ? "Ativado" : "Desativado"; ?></td>
    <td class="text-center">
        <a href="<?= url("pages/product/edit/" . $product->slug); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="edit"></span>
        </a>
        <a href="#" data-action="<?= url("pages/product/delete"); ?>" data-id="<?= $product->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>