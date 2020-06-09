<?php

namespace Theme\Pages\Banner;

use League\Plates\Engine;
use Source\Controllers\Upload;

/**
 * Class BannerController
 * @package Theme\Pages\Banner
 *
 * @property BannerModel $banner
 * @property Upload $upload
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
        $message = null;
        if (! empty($_GET['type'])) {
            $message = message($_GET['type'], $_GET['type']);
        }

        echo $this->view->render("banner/view/index", [
            "banners" => (new BannerModel())->find()->order('id')->fetch(true),
            'message' => $message
        ]);
    }

    public function create(array $data = null)
    {
        if (! empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (empty($data["title"]) || empty($data["description"]) || ! empty($_FILES["file"]["error"])) {
                redirect("/pages/banner?type=error");
            }

            $banner = new BannerModel();
            $banner->title = $data["title"];
            $banner->slug = str_replace(' ', '-', utf8_decode(strtolower($data['title'])));
            $banner->description = $data["description"];

            if (! empty($_FILES)) {
                $upload = new Upload();
                $upload->setArquivo($_FILES);
                $upload->setDestinho("banner");
                $nameImage = $upload->upload();

                if (! $nameImage) {
                    redirect("/pages/banner?type=error");
                }

                $banner->image = $nameImage;
            }

            if (! $banner->save()) {
                redirect("/pages/banner?type=error");
            }

            redirect("/pages/banner?type=success");
        }

        echo $this->view->render("banner/view/create");
    }

    public function delete(array $data)
    {
        if (empty($data['id'])) {
            return false;
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $user = (new BannerModel())->findById($id);

        if (! empty($user)) {
            if (! $user->destroy()) {
                return false;
            }
        }

        $callback['remove'] = true;
        echo json_encode($callback);
    }
}
