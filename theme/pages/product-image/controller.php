<?php

namespace Theme\Pages\ProductImage;

use Source\Controllers\Controller;
use Source\Controllers\Upload;
use Theme\Pages\Product\ProductModel;

/**
 * Class ProductImageController
 * @package Theme\Pages\ProductImage
 *
 * @property ProductImageModel $productImage
 */
class ProductImageController extends Controller
{
    /**
     * ProductImageController constructor.
     *
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * Página index do Produtos Imagem.
     */
    public function index(): void
    {
        $data = filter_var_array($_GET, FILTER_SANITIZE_STRING);

        if (empty($data["product_id"]) || ! $product = (new ProductModel())->findById($data["product_id"])) {
            redirect("pages/product");
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/product-image"),
            ""
        )->render();

        echo $this->view->render("product-image/view/index", [
            "product" => $product,
            "productImages" => (new ProductImageModel())->find("id_product = :id_product", "id_product={$product->id}")->order('id')->fetch(true),
            'head' => $head
        ]);
    }

    /**
     * Página Edit do Produtos Imagem.
     *
     * @param array $data
     */
    public function edit(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $slug = $data["slug"];
        unset($data["slug"]);

        if (empty($slug) || ! $productImage = (new ProductImageModel())->find("slug = :slug", "slug={$slug}")->fetch()) {
            redirect("pages/product");
        }

        $product = (new ProductModel())->findById($productImage->id_product);

        if (! empty($data)) {
            printrx($data);
            $productImage->status = $data["status"];
            $productImage->title = $data["title"];
            $productImage->slug = slugify($data['title']);
            $productImage->description = ! empty($data["description"]) ? trim($data["description"]) : '';
            $productImage->old_value = $data["old_value"] ?: 0;
            $productImage->current_value = $data["current_value"];
            $productImage->stock = (int) $data["stock"];
            $productImage->code = $data["code"];

            if (! $productImage->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao editar o Estoque"
                ]);
                return;
            }

            flash("success", "Estoque editado com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/product-image/edit/" . $productImage->id)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/product-image/edit/$slug"),
            ""
        )->render();

        echo $this->view->render("product-image/view/edit", [
            "product" => $product,
            "productImage" => $productImage,
            "head" => $head
        ]);
    }

    /**
     * Página de cadastro de Produtos Imagem.
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);

        $slugProduct = $data["slug"];
        unset($data["slug"]);

        if (empty($slugProduct) || ! $product = (new ProductModel())->find("slug = :slug", "slug={$slugProduct}")->fetch()) {
            redirect("pages/product");
        }

        if (! empty($_FILES)) {
            if ($_FILES['error'] != 0) {
                flash("danger", "Erro ao realizar o upload do arquivo");
                redirect("pages/product-image/create/" . $product->id);
                return;
            }

            $productImage = new ProductImageModel();
            $productImage->id_product = $product->id;

            $upload = new Upload();
            $upload->setFile($_FILES);
            $upload->setDestiny("product");
            $nameImage = $upload->upload();

            if (empty($nameImage)) {
                flash("danger", "Erro ao realizar o upload do arquivo");
                redirect("pages/product-image/create/" . $product->id);
                return;
            }

            $productImage->image = $nameImage;

            if (! $productImage->save()) {
                flash("danger", "Erro ao cadastrar a Imagem");
                redirect("pages/product-image/create/" . $product->id);
                return;
            }

            flash("success", "Imagem cadastrado com sucesso");
            redirect("pages/product-image?product_id=" . $productImage->id_product);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/product-image/create/" . $product->slug),
            ""
        )->render();

        echo $this->view->render("product-image/view/create", [
            "head" => $head,
            "product" => $product
        ]);
    }

    /**
     * Responsavel por deletar Produtos Imagem via Ajax.
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
        $productImage = (new ProductImageModel())->findById($id);

        if (! empty($productImage)) {
            if (! $productImage->destroy()) {
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
