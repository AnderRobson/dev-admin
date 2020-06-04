<tr>
    <td><?= $banner->title ?></td>
    <td><?= $banner->slug ?></td>
    <td><?= $banner->description ?></td>
    <td class="text-center">
        <a href="<?= $banner->image ?>" target="_blank" class="btn btn-outline-secondary active" role="button" aria-pressed="true">
            <span data-feather="image"></span>
        </a>
        <a href="#" class="remove" data-action="<?= url("/pages/banner/delete"); ?>" data-id="<?= $banner->id; ?>">Deletar</a>
    </td>
</tr>