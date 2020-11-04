<?php

namespace Theme\Pages\Publication;

use Source\Controllers\Controller;
use Source\Controllers\Upload;

/**
 * Class PublicationController
 * @package Theme\Pages\Publication
 *
 * @property PublicationModel $publication
 *
 */
class PublicationController extends Controller
{
    /**
     * Página index publicação
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/publication"),
            ""
        )->render();

        echo $this->view->render("publication/view/index", [
            "publications" => (new PublicationModel())->find()->order('id')->fetch(true),
            "head" => $head
        ]);
    }

    /**
     * Página Edit do Publicação.
     *
     * @param array $data
     */
    public function edit(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $slug = $data["slug"];
        unset($data["slug"]);

        if (! empty($data)) {
            $publication = (new PublicationModel())->findById($data["id"]);
            $publication->title = $data["title"];
            $publication->slug = slugify($data['title']);
            $publication->description = $data["description"];
            $publication->status = (bool) $data["status"];

            if (! empty($_FILES)) {
                $upload = new Upload();
                $upload->setFile($_FILES);
                $upload->setDestiny("publication");
                $nameImage = $upload->upload();

                if (empty($nameImage)) {
                    echo $this->ajaxResponse("message", [
                        "type" => "danger",
                        "message" => "Erro ao realizar o upload do arquivo"
                    ]);
                    return;
                }

                $publication->image = $nameImage;
            }

            if (! $publication->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao editar a publicação"
                ]);
                return;
            }

            flash("success", "Publicação editado com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/publication/edit/" . $publication->slug)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/publication"),
            ""
        )->render();

        echo $this->view->render("publication/view/edit", [
            "publication" => (new PublicationModel())->find("slug = :slug", "slug={$slug}")->fetch(),
            'head' => $head
        ]);
    }

    /**
     * Página de cadastro de Publicação.
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
                    "message" => "Erro ao cadastrar a Publibação"
                ]);
                return;
            }

            $publication = new PublicationModel();
            $publication->title = $data['title'];
            $publication->slug = slugify($data['title']);
            $publication->description = $data['description'];
            $publication->status = (bool) $data["status"];

            if (! empty($_FILES["file"])) {
                $upload = new Upload();
                $upload->setFile($_FILES);
                $upload->setDestiny("publication");
                $nameImage = $upload->upload();

                if (! $nameImage) {
                    echo $this->ajaxResponse("message", [
                        "type" => "danger",
                        "message" => "Erro ao realizar o upload do arquivo"
                    ]);
                    return;
                }

                $publication->image = $nameImage;
            }

            if (! $publication->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar a Publicação"
                ]);
                return;
            }

            flash("success", "Publicação cadastrada com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/publication/edit/" . $publication->slug)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/publication/create"),
            ""
        )->render();

        echo $this->view->render("publication/view/create", [
            "head" => $head
        ]);
    }

    /**
     * Responsavel por deletar Publicação via Ajax.
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
        $publication = (new PublicationModel())->findById($id);

        if (! empty($publication)) {
            $publication->destroy();
        }

        $callback['remove'] = true;
        echo json_encode($callback);
        return;
    }

    /**
     * Responsavel por gerar publicações para debug.
     */
    public function generatePublication ()
    {
        require_once ROOT . DS . 'theme/pages/exemplos/generate/generatePublication.php';
    }
}
