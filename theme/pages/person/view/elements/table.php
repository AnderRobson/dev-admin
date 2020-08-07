<tr>
    <td><?= $person->first_name . " " . $person->last_name; ?></td>
    <td><?= $person->date_birth; ?></td>
    <td><?= $person->city; ?></td>
    <td class="text-center">
        <a href="<?= url("pages/person/edit/" . $person->id); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="edit"></span>
        </a>
        <a href="#" data-action="<?= url("pages/person/delete"); ?>" data-id="<?= $person->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>
