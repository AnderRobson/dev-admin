<?php

namespace Theme\Pages\Banner;

use Exception;
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
     * Página index banner
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/banner"),
            ""
        )->render();

        echo $this->view->render("banner/view/index", [
            "banners" => (new BannerModel())->find()->order('id')->fetch(true),
            'head' => $head
        ]);
    }

    /**
     * Página Edit do Banner.
     *
     * @param array $data
     */
    public function edit(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $slug = $data["slug"];
        unset($data["slug"]);

        if (! empty($data)) {
            $banner = (new BannerModel())->findById($data["id"]);
            $banner->title = $data["title"];
            $banner->slug = slugify($data['title']);
            $banner->description = $data["description"];
            $banner->status = (bool) $data["status"];

            if (! empty($_FILES['file']['name'])) {
                try {

                    $upload = new Upload();
                    $upload->setFile($_FILES);
                    $upload->setDestiny("banner");
                    $nameImage = $upload->upload();

                } catch (Exception $exception) {
                    flash("danger", $exception->getMessage());
                    redirect("pages/banner/edit/" . $banner->slug);
                    return;
                }

                $banner->image = $nameImage;
            }

            if (! $banner->save()) {
                flash("danger", "Erro ao editar o Banner");
                redirect("pages/banner/edit/" . $banner->slug);
                return;
            }

            flash("success", "Banner editado com sucesso");
            redirect("pages/banner/edit/" . $banner->slug);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/banner"),
            ""
        )->render();

        echo $this->view->render("banner/view/edit", [
            "banner" => (new BannerModel())->find("slug = :slug", "slug={$slug}")->fetch(),
            'head' => $head
        ]);
    }

    /**
     * Página de cadastro de Banner.
     *
     * @param array|null $data
     */
    public function create(array $data = null)
    {
        if (! empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);
            if (empty($data["title"]) || empty($data["description"]) || ! empty($_FILES["file"]["error"])) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar o Banner"
                ]);
                return;
            }

            $banner = new BannerModel();
            $banner->title = $data["title"];
            $banner->slug = slugify($data['title']);
            $banner->description = $data["description"];
            $banner->status = (bool) $data["status"];

            if (! empty($_FILES['file']['name'])) {
                try {

                    $upload = new Upload();
                    $upload->setFile($_FILES);
                    $upload->setDestiny("banner");
                    $nameImage = $upload->upload();

                } catch (Exception $exception) {
                    flash("danger", $exception->getMessage());
                    redirect("pages/banner/create");
                    return;
                }

                $banner->image = $nameImage;
            }

            if (! $banner->save()) {
                flash("danger", "Erro ao cadastrar o Banner");
                redirect("pages/banner/create");
                return;
            }

            flash("success", "Banner cadastrado com sucesso");
            redirect("pages/banner/edit/" . $banner->slug);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/banner/create"),
            ""
        )->render();

        echo $this->view->render("banner/view/create", [
            'head' => $head
        ]);
    }

    /**
     * Responsavel por deletar Banner via Ajax.
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
        $banner = (new BannerModel())->findById($id);

        if (! empty($banner)) {
            if (! $banner->destroy()) {
                $callback['remove'] = false;
                echo json_encode($callback);

                return;
            }
        }

        $callback['remove'] = true;
        echo json_encode($callback);

        return;
    }

}