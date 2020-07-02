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
     * PublicationController constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * Página index publicação
     */
    public function index(): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/publication"),
            "",
        )->render();

        echo $this->view->render("publication/view/index", [
            "publications" => (new PublicationModel())->find()->order('id')->fetch(true),
            "head" => $head
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
                redirect("pages/publication?type=error");
                return;
            }

            $publication = new PublicationModel();
            $publication->title = $data['title'];
            $publication->slug = slugify($data['title']);
            $publication->description = $data['description'];

            if (! empty($_FILES["file"])) {
                $upload = new Upload();
                $upload->setArquivo($_FILES);
                $upload->setDestinho("publication");
                $nameImage = $upload->upload();

                if (! $nameImage) {
                    redirect("pages/publication?type=error");
                }

                $publication->image = $nameImage;
            }

            if (! $publication->save()) {
                redirect("pages/publication?type=error");
            }

            redirect("pages/publication?type=success");
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/publication/create"),
            "",
        )->render();

        echo $this->view->render("publication/view/create", [
            "head" => $head
        ]);
    }

    /**
     * Responsavel por realizar a exlusão de uma publicação.
     *
     * @param array $data
     * @return bool
     */
    public function delete(array $data)
    {
        if (empty($data['id'])) {
            return false;
        }

        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $publication = (new PublicationModel())->findById($id);

        if (! empty($publication)) {
            $publication->destroy();
        }

        $callback['remove'] = true;
        echo json_encode($callback);
    }

    /**
     * Método responsavel por gerar publicações automatico para debug.
     */
    public function generatePublication ()
    {
        require_once ROOT . DS . 'theme/pages/exemplos/generate/generatePublication.php';
    }
}
