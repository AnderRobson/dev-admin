<?php


namespace Theme\Pages\Order;


use Source\Controllers\Controller;
use Source\Library\Paginator\Paginator;

class OrderController extends Controller
{

    public function index()
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/order"),
            ""
        )->render();

        $orders = (new OrderModel())->find();

        $page = isset($data["paginate"]) ? $data["paginate"] : 1;
        $limit = isset($data["limit"]) ? $data["limit"] : 20;

        $pager = new Paginator(url('pages/order?' . (isset($data["limit"]) ? 'limit=' . $limit . '&' : '') . 'paginate='));
        $pager->pager($orders->count(), $limit, $page, 2);

        $this->user->setOrders($orders->limit($pager->limit())->offset($pager->offset())->fetch(true));

        echo $this->view->render("order/view/index", [
            'head' => $head,
            'orders' => $this->user->getOrders(),
            "pager" => $pager
        ]);
    }
}