<?php

namespace Theme\Pages\Publication;

use League\Plates\Engine;
use Source\Controllers\Upload;

/**
 * Class PublicationController
 * @package Theme\Pages\Publication
 *
 * @property PublicationModel $publication
 *
 */
class PublicationController
{
    /** @var Engine  */
    private $view;

    /** @var data funcionara tipo um cache */
    private $data;

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

        echo $this->view->render("publication/view/index", [
            "publications" => (new PublicationModel())->find()->order('id')->fetch(true),
            'message' => $message
        ]);
    }

    public function create(array $data = null)
    {
        if (! empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (empty($data["title"]) || empty($data["description"]) || ! empty($_FILES["file"]["error"])) {
                redirect("/pages/publication?type=error");
                return;
            }

            $publication = new PublicationModel();
            $publication->title = $data['title'];
            $publication->slug = str_replace(' ', '-', utf8_decode(strtolower($data['title'])));
            $publication->description = $data['description'];

            if (! empty($_FILES["file"])) {
                $upload = new Upload();
                $upload->setArquivo($_FILES);
                $upload->setDestinho("publication");
                $nameImage = $upload->upload();

                if (! $nameImage) {
                    redirect("/pages/publication?type=error");
                }

                $publication->image = $nameImage;
            }

            if (! $publication->save()) {
                redirect("/pages/publication?type=error");
            }

            redirect("/pages/publication?type=success");
        }

        echo $this->view->render("publication/view/create");
    }

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
}
