<?php $v->layout("_theme", ["title" => "Usu�rios"]); ?>

<div class="create">
    <div class="form" style="display: none"></div>
    <form class="form" name="gallery" action="" method="post" enctype="multipart/form-data">
        <label>
            <input type="text" name="first_name" placeholder="Nome:"/>
        </label>
        <label>
            <input type="text" name="last_name" placeholder="Sobrenome:"/>
        </label>
        <button>Cadastrar Usu�rio</button>
    </form>
</div>

<section class="users">
    <?php for ($i = 0; $i < 5; $i++): ?>
        <article class="users_user">
            <h3>Nome Sobrenome</h3>
            <a href="#" class="remove">Deletar</a>
        </article>
    <?php endfor; ?>
</section>
