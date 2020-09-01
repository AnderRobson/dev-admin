<?php


namespace Theme\pages\settings;


use Source\Controllers\Controller;
use Source\Models\Configures;

class SettingsController extends Controller
{
    /**
     * StockController constructor.
     *
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function index($data = null)
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/settings"),
            "",
            )->render();

        echo $this->view->render("settings/view/index", [
            "head" => $head,
            'configures' => (new Configures())->getAllConfigures()
        ]);
    }

    public function edit(array $data)
    {
        $idConfigure = $data["slug"];
        unset($data["slug"]);

        $configure = (new Configures())->findById($idConfigure);

        if (empty($configure)) {
            flash("danger", "Configura��o n�o encontrada");
            redirect("pages/settings");
        }

        if (! empty($data)) {
            $configure->id = $data['id'];
            $configure->name = $data['name'];
            $configure->value = strip_tags($data['value']);
            $configure->status = $data['status'];


            if (! $configure->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao editar a configura��o"
                ]);
                return;
            }

            echo $this->ajaxResponse("message", [
                "type" => "success",
                "message" => "Configura��o editada com sucesso"
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/settings"),
            "",
            )->render();

        echo $this->view->render("settings/view/edit", [
            "head" => $head,
            'configure' => $configure
        ]);
    }

    /**
     * P�gina de cadastro de Configura��es.
     *
     * @param array|null $data
     */
    public function create(array $data = null)
    {
        if (! empty($data)) {
            if (empty($data["name"]) || empty($data["value"])) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar a Configura��o"
                ]);
                return;
            }

            $configure = new Configures();
            $configure->name = $data['name'];
            $configure->value = strip_tags($data['value']);
            $configure->status = (bool) $data["status"];

            if (! $configure->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar a Configura��o"
                ]);
                return;
            }

            echo $this->ajaxResponse("message", [
                "type" => "success",
                "message" => "Configura��o cadastrada com sucesso"
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/publication/create"),
            ""
        )->render();

        echo $this->view->render("settings/view/create", [
            "head" => $head
        ]);
    }

    /**
     * Responsavel por deletar Configura��es via Ajax.
     *
     * @param array $data
     * @return bool
     */
    public function delete(array $data): void
    {
        if (empty($data['id'])) {
            $callback['remove'] = false;
            echo json_encode($callback);

            return;
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $configure = (new Configures())->findById($id);

        if (! empty($configure)) {
            $configure->destroy();
        }

        $callback['remove'] = true;
        echo json_encode($callback);
        return;
    }
}