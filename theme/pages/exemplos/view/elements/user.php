<article class="users_user">
    <h3><?= $user->name ?></h3>
    <a href="#" class="remove" data-action="<?= url("/pages/home/delete"); ?>" data-id="<?= $user->id; ?>">Deletar</a>
</article>