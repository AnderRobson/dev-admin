<tr>
    <td><?= $publication->title; ?></td>
    <td><?= $publication->slug; ?></td>
    <td><?= substr( $publication->description, 0, 90); ?></td>
    <td><?= $publication->image; ?></td>
    <td class="text-center">
        <?php if (! empty($publication->image)): ?>
            <a href="<?= urlFile('publication' . DS . $publication->image); ?>" target="_blank" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                <span data-feather="image"></span>
            </a>
        <?php endif; ?>
        <a href="#" data-action="<?= url("/pages/publication/delete"); ?>" data-id="<?= $publication->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>
