<tr>
    <td><?= $configure->name; ?></td>
    <td><?= substr(json_encode($configure->value, true), 0, 130); ?></td>
    <td><?= $configure->status ? "Ativado" : "Desativado";; ?></td>
    <td class="text-center">
        <a href="<?= url("pages/settings/edit/" . $configure->id); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="edit"></span>
        </a>
        <a href="#" data-action="<?= url("pages/settings/delete"); ?>" data-id="<?= $configure->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>
