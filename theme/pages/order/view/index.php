<?php
$v->layout("order/view/_theme"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
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
