<div class="card">
    <div class="card-header" id="headingOne">
        <!--        <a class="btn btn-lg" data-toggle="collapse" href="#collapseOne--><!--" role="button" aria-expanded="true" aria-controls="collapseOne">-->
        <table class="table table-striped text-center">
            <tbody>
            <tr>
                <td><?= $order->id; ?></td>
                <td class="bg-<?= $order->getStatus('class'); ?> text-black"><?= $order->getStatus('status') ?></td>
                <td><?= currencyFormatter($order->sub_total); ?></td>
                <td><?= currencyFormatter($order->total); ?></td>
            </tr>
            </tbody>
        </table>
        <!--        </a>-->
    </div>

    <div id="collapseOne<?= $order->id; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-5">
                    <div class="row">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Seu Pedido</span>
                            <span class="badge badge-secondary badge-pill">3</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Frete</h6>
                                </div>
                                <span><?= currencyFormatter($order->freight); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light"
                                <?=
                                empty($order->discount)
                                    ?
                                    'style="display: none !important"'
                                    :
                                    '';
                                ?>
                            >
                                <div class="text-success">
                                    <h6 class="my-0">Descontos</h6>
                                </div>
                                <span class="text-success"><?= currencyFormatter($order->discount); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="my-0">Sub Total</h6>
                                </div>
                                <span><?= currencyFormatter($order->sub_total); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="my-0">Valor Pago</h6>
                                </div>
                                <strong><?= currencyFormatter($order->total); ?></strong>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Endereço de Entrega</span>
                            <span class="badge badge-secondary badge-pill">3</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Rua</h6>
                                </div>
                                <input type="text" id="street" name="street" class="input-none text-right" value="<?= $address->street; ?>" style="max-width: 80%;" readonly>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div>
                                    <h6 class="my-0">Número</h6>
                                </div>
                                <input type="text" id="number" name="number" class="input-none text-right" value="<?= $address->number; ?>" style="max-width: 70%;" readonly>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Bairro</h6>
                                </div>
                                <input type="text" id="district" name="district" class="input-none text-right" value="<?= $address->district; ?>" style="max-width: 80%;" readonly>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div>
                                    <h6 class="my-0">Cidade</h6>
                                </div>
                                <input type="text" id="city" name="city" class="input-none text-right" value="<?= $address->city; ?>" style="max-width: 80%;" readonly>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Estado</h6>
                                </div>
                                <input type="text" id="state" name="state" class="input-none text-right" value="<?= $address->state->name; ?>" style="max-width: 80%;" readonly>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 order-md-1">
                    <div class="container-fluid">
                        <table class="table table-striped text-center">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Código</th>
                                <th scope="col">Título</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Valor Unidade</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if (! empty($order->orderProduct)):
                                    foreach ($order->orderProduct as $product) {
                                        $v->insert(
                                            "user/view/elements/productConfirmation",
                                            [
                                                'product' => $product->getProduct(),
                                                'stock' => $product->product->getStock(),
                                                'productImages' => $product->product->getImage()
                                            ]
                                        );
                                    }
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
