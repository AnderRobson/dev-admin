<?php

namespace Theme\Pages\Product;

use Source\Controllers\Controller;
use Source\Controllers\Upload;

/**
 * Class ProductController
 * @package Theme\Pages\Product
 *
 * @property ProductModel $product
 * @property Upload $upload
 */
class ProductController extends Controller
{
    /**
     * BannerController constructor.
     *
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
            url("pages/product"),
            ""
        )->render();

        echo $this->view->render("product/view/index", [
            "products" => (new ProductModel())->find()->order('id')->fetch(true),
            'head' => $head
        ]);
    }

    /**
     * Página Edit do Produto.
     *
     * @param array $data
     */
    public function edit(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $slug = $data["slug"];
        unset($data["slug"]);

        if (! empty($data)) {
            $product = (new ProductModel())->findById($data["id"]);
            $product->title = $data["title"];
            $product->slug = slugify($data['title']);
            $product->description = trim($data["description"]);
            $product->code = $data["code"];
            $product->status = (bool) $data["status"];

            if (! $product->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao editar o Produto"
                ]);
                return;
            }

            flash("success", "Produto editado com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/product/edit/" . $product->slug)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/product/edit/$slug"),
            ""
        )->render();

        echo $this->view->render("product/view/edit", [
            "product" => (new ProductModel())->find("slug = :slug", "slug={$slug}")->fetch(),
            'head' => $head
        ]);
    }

    /**
     * Página de cadastro de Produto.
     *
     * @param array|null $data
     */
    public function create(array $data = null)
    {
        if (! empty($data)) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);

            if (empty($data["title"]) || empty($data["description"]) || empty($data["code"])) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar o Produto"
                ]);
                return;
            }

            $product = new ProductModel();
            $product->title = $data["title"];
            $product->slug = slugify($data['title']);
            $product->description = trim($data["description"]);
            $product->code = $data["code"];
            $product->status = (bool) $data["status"];

            if (! $product->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar o Produto"
                ]);
                return;
            }

            flash("success", "Produto cadastrado com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/product/edit/" . $product->slug)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/product/create"),
            ""
        )->render();

        echo $this->view->render("product/view/create", [
            'head' => $head
        ]);
    }

    /**
     * Responsavel por deletar Produto via Ajax.
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
        $user = (new ProductModel())->findById($id);

        if (! empty($user)) {
            if (! $user->destroy()) {
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
