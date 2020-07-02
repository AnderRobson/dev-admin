<?php

namespace Theme\Pages\Banner;

use Source\Controllers\Controller;
use Source\Controllers\Upload;

/**
 * Class BannerController
 * @package Theme\Pages\Banner
 *
 * @property BannerModel $banner
 * @property Upload $upload
 */
class BannerController extends Controller
{
    /**
     * BannerController constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * Página index banner
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/banner"),
            "",
        )->render();

        echo $this->view->render("banner/view/index", [
            "banners" => (new BannerModel())->find()->order('id')->fetch(true),
            'head' => $head
        ]);
    }

    /**
     * @param array|null $data
     */
    public function create(array $data = null)
    {
        if (! empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (empty($data["title"]) || empty($data["description"]) || ! empty($_FILES["file"]["error"])) {
                redirect("pages/banner?type=error");
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
                    redirect("pages/banner?type=error");
                }

                $banner->image = $nameImage;
            }

            if (! $banner->save()) {
                redirect("pages/banner?type=error");
            }

            redirect("pages/banner?type=success");
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/banner/create"),
            "",
        )->render();

        echo $this->view->render("banner/view/create", [
            'head' => $head
        ]);
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
