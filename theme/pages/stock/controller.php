<?php

namespace Theme\Pages\Stock;

use Source\Controllers\Controller;
use Theme\Pages\Product\ProductModel;

/**
 * Class StockController
 * @package Theme\Pages\Stock
 *
 * @property StockModel $stock
 */
class StockController extends Controller
{
    /**
     * StockController constructor.
     *
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * Página index do Estoque.
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
            url("pages/stock"),
            ""
        )->render();

        echo $this->view->render("stock/view/index", [
            "product" => $product,
            "stock" => (new StockModel())->find("id_product = :id_product", "id_product={$data["product_id"]}")->order('id')->fetch(true),
            'head' => $head
        ]);
    }

    /**
     * Página Edit do Estoque.
     *
     * @param array $data
     */
    public function edit(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $slug = $data["slug"];
        unset($data["slug"]);

        if (empty($slug) || ! $stock = (new StockModel())->find("slug = :slug", "slug={$slug}")->fetch()) {
            redirect("pages/product");
        }

        $product = (new ProductModel())->findById($stock->id_product);

        if (! empty($data)) {
            $stock->status = $data["status"];
            $stock->title = $data["title"];
            $stock->slug = slugify($data['title']);
            $stock->description = ! empty($data["description"]) ? trim($data["description"]) : '';
            $stock->old_value = $data["old_value"] ? number_format(str_replace(',', '.', $data["old_value"]), 2) : 0;
            $stock->current_value = number_format(str_replace(',', '.', $data["current_value"]), 2);
            $stock->stock = (int) $data["stock"];
            $stock->code = $data["code"];

            if (! $stock->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao editar o Estoque"
                ]);
                return;
            }

            flash("success", "Estoque editado com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/stock/edit/" . $stock->slug)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/stock/edit/$slug"),
            ""
        )->render();

        echo $this->view->render("stock/view/edit", [
            "product" => $product,
            "stock" => $stock,
            "head" => $head
        ]);
    }

    /**
     * Página de cadastro de Estoque.
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

        if (! empty($data)) {
            if (empty($data["title"]) || empty($data["description"]) || empty($data["code"])) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar o Estoque"
                ]);
                return;
            }

            $stock = new StockModel();
            $stock->id_product = $product->id;
            $stock->status = $data["status"];
            $stock->title = $data["title"];
            $stock->slug = slugify($data['title']);
            $stock->description = trim($data["description"]) ?: '';
            $stock->old_value = $data["old_value"] ?: 0;
            $stock->current_value = $data["current_value"];
            $stock->stock = (int) $data["stock"];
            $stock->code = $data["code"];

            if (! $stock->save()) {
                echo $this->ajaxResponse("message", [
                    "type" => "danger",
                    "message" => "Erro ao cadastrar o Estoque"
                ]);
                return;
            }

            flash("success", "Estoque cadastrado com sucesso");
            echo $this->ajaxResponse("redirect", [
                "url" => url("pages/stock/edit/" . $stock->slug)
            ]);
            return;
        }

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/stock/create/" . $product->slug),
            ""
        )->render();

        echo $this->view->render("stock/view/create", [
            "head" => $head,
            "product" => $product
        ]);
    }

    /**
     * Responsavel por deletar Estoque via Ajax.
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
        $stock = (new StockModel())->findById($id);

        if (! empty($stock)) {
            if (! $stock->destroy()) {
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
