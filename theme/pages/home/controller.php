<?php

namespace Theme\Pages\Home;

use League\Plates\Engine;
include 'model.php';

class HomeController
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
        echo $this->view->render("home/view/index", [
//            "users" => (new BannerModel())->find()->order('first_name')->fetch(true)
        ]);
    }

    public function create(array $data)
    {
        $userData = filter_var_array($data, FILTER_SANITIZE_STRING);

        if (in_array("", $userData)) {
            $callback["message"] = message("Informe o nome e o sobrenome !", "error");
            echo json_encode($callback);
            return;
        }

        $user = new HomeModel();
        $user->first_name = $userData["first_name"];
        $user->last_name = $userData["last_name"];
        $user->save();

        $callback["message"] = message("Usuário cadastrado com sucesso !", "success");
        $callback["user"] = $this->view->render("home/view/elements/user", ["user" => $user]);

        echo json_encode($callback);
    }

    public function delete(array $data)
    {
        if (empty($data['id'])) {
            return false;
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $user = (new HomeModel())->findById($id);

        if (! empty($user)) {
            $user->destroy();
        }

        $callback['remove'] = true;
        echo json_encode($callback);
    }
}
