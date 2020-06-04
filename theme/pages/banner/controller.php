<?php

namespace Theme\Pages\Banner;

use League\Plates\Engine;
use Theme\Pages\Banner\BannerModel;

/**
 * Class BannerController
 * @package Theme\Pages\Banner
 *
 * @property BannerModel $banner
 */
class BannerController
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
        echo $this->view->render("banner/view/index", [
            "banners" => (new BannerModel())->find()->order('id')->fetch(true)
        ]);
    }

    public function create(array $data = null)
    {
        if (! empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (empty($data["title"]) || empty($data["description"]) || $_FILES["file"]["error"] != 0) {
                $callback["message"] = message("Esta faltando informação para cadastrar banner !", "error");
                echo json_encode($callback);
                return;
            }

            $name = date("YmdHis");
            $nameImage = $name . $_FILES["file"]["name"];

            move_uploaded_file($_FILES["file"]["tmp_name"], 'upload/banner/'. $nameImage);

            $banner = new BannerModel();
            $banner->title = $data["title"];
            $banner->description = $data["description"];

            $banner->image = $nameImage;
            $banner->save();

            $callback["message"] = message("Banner cadastrado com sucesso !", "success");
//            $callback["user"] = $this->view->render("banner/view/elements/user", ["user" => $user]);

            echo json_encode($callback);
            return;
        }

        echo $this->view->render("banner/view/create", [
//            "users" => (new BannerModel())->find()->order('first_name')->fetch(true)
        ]);
    }

    public function delete(array $data)
    {
        if (empty($data['id'])) {
            return false;
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $user = (new BannerModel())->findById($id);

        if (! empty($user)) {
            $user->destroy();
        }

        $callback['remove'] = true;
        echo json_encode($callback);
    }
}
