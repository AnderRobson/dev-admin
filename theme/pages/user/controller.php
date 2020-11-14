<?php

namespace Theme\Pages\User;

use Source\Controllers\Controller;
use Source\Library\Paginator\Paginator;
use Theme\Pages\Address\AddressModel;
use Theme\Pages\Order\OrderModel;

/**
 * Class UserController
 * @package Theme\Pages\Exemplos
 */
class UserController extends Controller
{
    /**
     * Página index exemplo
     */
    public function index($data = null): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/user"),
            ""
        )->render();

        $this->user->getUser()->person->getAddress();
        $this->user->getUser()->person->address->getState();

        $orders = (new OrderModel())->find(
            'id_user = :id_user',
            'id_user=' . $this->user->getUser()->id
        );

        $page = isset($data["paginate"]) ? $data["paginate"] : 1;
        $limit = isset($data["limit"]) ? $data["limit"] : 20;

        $pager = new Paginator(url('pages/user?' . (isset($data["limit"]) ? 'limit=' . $limit . '&' : '') . 'paginate='));
        $pager->pager($orders->count(), $limit, $page, 2);

        $this->user->setOrders($orders->limit($pager->limit())->offset($pager->offset())->fetch(true));

        echo $this->view->render("user/view/index", [
            'head' => $head,
            'orders' => $this->user->getOrders(),
            "pager" => $pager
        ]);
    }

    public function edit_address($data)
    {
        $this->user->getUser()->person->getAddress();
        $this->user->getUser()->person->address->getState();

        $address = new AddressModel();
        if (! empty($data["id"])) {
            $address->id = (int)$data["id"];
        }

        $address->street = $data["street"];
        $address->number = (int) $data["number"];
        $address->district = $data["district"];
        $address->zip_code = $data["zip_code"];
        $address->city = $data["city"];

        if (! empty($data["state"])) {
            $address->id_state = (int) $data["state"];
        }

        if (! $address->save()) {
            echo $this->ajaxResponse("message", [
                "type" => "danger",
                "message" => "Erro ao editar o Endereço"
            ]);

            return;
        }

        echo $this->ajaxResponse("message", [
            "type" => "success",
            "message" => "Endereço editado com Sucesso"
        ]);
    }
}
