<tr>
    <td><?= $banner->title; ?></td>
    <td><?= $banner->slug; ?></td>
    <td><?= substr($banner->description, 0, 90); ?></td>
    <td><?= $banner->image; ?></td>
    <td class="text-center">
        <?php if (! empty($banner->image)): ?>
            <a href="<?= urlFile('banner' . DS . $banner->image); ?>" target="_blank" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
                <span data-feather="image"></span>
            </a>
        <?php endif; ?>
        <a href="#" data-action="<?= url("/pages/banner/delete"); ?>" data-id="<?= $banner->id; ?>" class="remove btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="delete"></span>
        </a>
    </td>
</tr>