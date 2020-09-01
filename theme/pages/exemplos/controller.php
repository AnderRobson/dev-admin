<?php

namespace Theme\Pages\Exemplos;

use Source\Controllers\Controller;

/**
 * Class ExemploController
 * @package Theme\Pages\Exemplos
 */
class ExemploController extends Controller
{
    /**
     * ExemploController constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * Página index exemplo
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/exemplos")
        )->render();

        echo $this->view->render("exemplos/view/index", [
            "users" => (new ExemplosModel())->find()->order('first_name')->fetch(true),
            'head' => $head
        ]);
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);

        if (in_array("", $data)) {
            $callback["message"] = message("Informe o nome e o sobrenome !", "error");
            echo json_encode($callback);
            return;
        }

        $user = new ExemplosModel();
        $user->first_name = $data["first_name"];
        $user->last_name = $data["last_name"];
        $user->save();

        $callback["message"] = message("Usuário cadastrado com sucesso !", "success");
        $callback["user"] = $this->view->render("exemplos/view/elements/user", ["user" => $user]);

        echo json_encode($callback);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function delete(array $data)
    {
        if (empty($data['id'])) {
            return false;
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $user = (new ExemplosModel())->findById($id);

        if (! empty($user)) {
//            $user->destroy();
        }

        $callback['remove'] = true;
        echo json_encode($callback);
    }
}
