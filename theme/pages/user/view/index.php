<?php
$v->layout("user/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php
        $v->insert("user/view/elements/navbar", [
            'productUrl' => "edit/" . $product->slug,
            "productId" => $product->id,
            "active" => "product"
        ]);
        ?>
        <div class="jumbotron" style="background-image: url('https://i0.wp.com/www.backlogreviews.com/wp-content/uploads/2018/10/0.-Follow-the-Banner.jpg?resize=1920%2C1080'); background-size: 100%; max-height: 1000px; object-fit: cover;">
            <div class="container">
                <div class="row">
                    <div class="ajax_load">
                        <div class="ajax_load_box">
                            <div class="ajax_load_box_circle"></div>
                            <div class="ajax_load_box_title jumbotrom">Aguarde, carregando!</div>
                        </div>
                    </div>
                    <?= flash(); ?>
                    <div class="form_ajax my-4" style="display: none"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 my-5">
                        <img src="<?= $user->photo; ?>" class="img-thumbnail block" alt="<?= $user->getFullName(); ?>" style="max-width: 350px; max-height: 360px; object-fit: cover">
                    </div>
                    <div class="col-md-8 my-5">
                        <div class="row box-white">
                            <h2 class="text-center"><?= $user->getFullName(); ?></h2>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-8 order-md-1 mb-5">
                                <div class="row box-white mr-1 mb-4">
                                    <div class="col-md-12 text-center">
                                        <h5 class="text-center">Status dos meus Pedidos</h5>
                                        <div class="row">
                                            <div class="col md-4 my-1 bg-secondary text-white">
                                                <h6>Pendentes: 0</h6>
                                            </div>
                                            <div class="col md-4 my-1 bg-primary text-white">
                                                <h6>Aprovados 0</h6>
                                            </div>
                                            <div class="col md-4 my-1 bg-info text-white">
                                                <h6>Transporte 0</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col md-4 bg-warning text-white">
                                                <h6>Abandonados 0</h6>
                                            </div>
                                            <div class="col md-4 bg-danger text-white">
                                                <h6>Cancelados 0</h6>
                                            </div>
                                            <div class="col md-4 bg-success text-white">
                                                <h6>Entregues 0</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row box-white mr-1">
                                    <div class="col-md-12">
                                        <h5 class="text-center">Meus Dados</h5>
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item transparent-input d-flex justify-content-between">
                                                <label for="street">Nome: </label>
                                                <input type="text" id="first_name" class="input-none text-right border border-white" value="<?= $user->person->first_name; ?>" style="max-width: 80%;" readonly>
                                                <input type="text" id="last_name" class="input-none text-right border border-white"value="<?= $user->person->last_name; ?>" style="max-width: 80%;" readonly>
                                            </li>
                                            <li class="list-group-item transparent-input d-flex justify-content-between">
                                                <label for="email">E-mail: </label>
                                                <input type="email" id="email" class="input-none text-right border border-white" value="<?= $user->email; ?>" style="width: 60%;" readonly>
                                            </li>
                                            <li class="list-group-item transparent-input d-flex justify-content-between">
                                                <label for="date_birth">Data de nascimento: </label>
                                                <input type="date" id="date_birth" class="input-none text-right border border-white" value="<?= $user->person->date_birth; ?>" style="max-width: 80%;" readonly>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 order-md-2 mb-5">
                                <div class="row box-white">
                                    <div class="col-md-12">
                                        <form action="<?= url("pages/user/edit_address"); ?>" id="editAddress" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6>Endereço de entrega</h6>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <input type="button" value="Editar" class="btn btn-sm btn-primary" id="btnEditAddress">
                                                    <input type="submit" value="Salvar" class="btn btn-sm btn-primary" id="btnSaveAddress" style="display: none">
                                                </div>
                                            </div>
                                            <div class="row" id="address">
                                                <input type="number" id="id" name="id" value="<?= $user->person->address->id; ?>" hidden readonly>
                                                <ul class="list-group mb-3">
                                                    <li class="list-group-item transparent-input d-flex justify-content-between">
                                                        <label for="street">Rua: </label>
                                                        <input type="text" id="street" name="street" class="input-none text-right border border-white" value="<?= $user->person->address->street; ?>" style="max-width: 80%;" readonly>
                                                    </li>
                                                    <li class="list-group-item transparent-input d-flex justify-content-between">
                                                        <label for="number">Número: </label>
                                                        <input type="text" id="number" name="number" class="input-none text-right border border-white" value="<?= $user->person->address->number; ?>" style="max-width: 80%;" readonly>
                                                    </li>
                                                    <li class="list-group-item transparent-input d-flex justify-content-between">
                                                        <label for="district">Bairro: </label>
                                                        <input type="text" id="district" name="district" class="input-none text-right border border-white" value="<?= $user->person->address->district; ?>" style="max-width: 80%;" readonly>
                                                    </li>
                                                    <li class="list-group-item transparent-input d-flex justify-content-between">
                                                        <label for="zip_code">CEP: </label>
                                                        <input type="text" id="zip_code" name="zip_code" class="input-none text-right border border-white" value="<?= $user->person->address->zip_code; ?>" style="max-width: 80%;" readonly>
                                                    </li>
                                                    <li class="list-group-item transparent-input d-flex justify-content-between">
                                                        <label for="city">Cidade: </label>
                                                        <input type="text" id="city" name="city" class="input-none text-right border border-white" value="<?= $user->person->address->city; ?>" style="max-width: 80%;" readonly>
                                                    </li>
                                                    <li class="list-group-item transparent-input d-flex justify-content-between">
                                                        <label for="state">Estado: </label>
                                                        <select name="state" id="state" class="input-none text-right border border-white" disabled>
                                                            <option value="0">selecione um estado</option>
                                                            <?php foreach ($user->person->address->getAllState() as $state): ?>
                                                                <option
                                                                        value="<?= $state->id; ?>"
                                                                    <?=
                                                                    ! empty($user->person->address->state->id)
                                                                    &&
                                                                    $state->id == $user->person->address->state->id
                                                                        ? 'selected'
                                                                        : '';
                                                                    ?>
                                                                ><?= $state->initials; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="box">
            <div class="container">
                <?= $pager->renderHeader(); ?>
                <div class="row">
                    <div class="col-md-12 order-md-1">
                        <div class="container-fluid">
                            <table class="table table-striped text-center">
                                <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Sub-Total</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (! empty($orders)):
                                    foreach ($orders as $order) {
                                        $v->insert(
                                            "user/view/elements/tableOrders",
                                            [
                                                'order' => $order
                                            ]
                                        );
                                    }
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
<!--                <div class="accordion" id="accordionExample">-->
<!--                    --><?php //if (! empty($orders)):
//                        foreach ($orders as $order) {
//                            $order->getOrderProduct();
//                            $v->insert(
//                                "user/view/elements/tableOrdersNew",
//                                [
//                                    'order' => $order,
//                                    "address" => $order->getAddress()->getState()
//                                ]
//                            );
//                        }
//                    endif; ?>
<!--                </div>-->
            </div>
            </div>
        </section>
    </main>
<?php
$v->start("css");
    echo css("profile");
    echo js("address");
$v->end();
