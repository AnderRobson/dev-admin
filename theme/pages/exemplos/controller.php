<?php

namespace Theme\Pages\Exemplos;

use League\Plates\Engine;

class ExemploController
{
    /** @var Engine  */
    private $view;

    public function __construct($router)
    {
        $this->view = Engine::create(
            ROOT . DS . 'theme/pages/',
            'php'
        );

        $this->view->addData(["router" => $router]);

        return $this;
    }

    public function index(): void
    {
        echo $this->view->render("exemplos/view/index", [
            "users" => (new ExemplosModel())->find()->order('name')->fetch(true)
        ]);
    }

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
