<tr>
    <td><?= $banner->title; ?></td>
    <td><?= $banner->slug; ?></td>
    <td><?= substr($banner->description, 0, 90); ?></td>
    <td class="text-center">
        <?php if (! empty($banner->image)): ?>
            <a href="<?= urlFile('upload/banner' . DS . $banner->image, true); ?>" target="_blank" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                <span data-feather="image"></span>
            </a>
        <?php endif; ?>
        <a href="<?= url("pages/banner/edit/" . $banner->slug); ?>" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="edit"></span>
        </a>
        <a href="#" data-action="<?= url("pages/banner/delete"); ?>" data-id="<?= $banner->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>