<tr>
    <td><?= $stock->code; ?></td>
    <td><?= $stock->title; ?></td>
    <td><?= substr($stock->description, 0, 30); ?></td>
    <td><?= $stock->stock; ?></td>
    <td><?= currencyFormatter($stock->old_value ?: 0); ?></td>
    <td><?= currencyFormatter($stock->current_value); ?></td>
    <td><?= $stock->status ? "Ativado" : "Desativado"; ?></td>
    <td class="text-center">
        <a href="<?= url("pages/stock/edit/" . $stock->slug); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="edit"></span>
        </a>
        <a href="#" data-action="<?= url("pages/stock/delete"); ?>" data-id="<?= $stock->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>