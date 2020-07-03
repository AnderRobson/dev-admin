<?php


namespace Theme\pages\person;


use Source\Controllers\Controller;
use Theme\pages\address\AddressModel;

/**
 * Class PersonController
 * @package Theme\pages\person
 *
 *
 */
class PersonController extends Controller
{
    /**
     * PersonController constructor.
     *
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function index(array $filters = null): void
    {
        $filter = $this->setFilters($filters);

        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/person"),
            "",
            )->render();

        $var = (new PersonModel());

        if (! empty($filter)) {
            $var->find($filter['keysFilter'], $filter['valueToFilter']);
        } else {
            $var->find();
        }

        echo $this->view->render("person/view/index", [
            "persons" => $var->order('first_name')->fetch(true),
            "states" => (new AddressModel())->getAllState(),
            "head" => $head
        ]);
    }

    private function setFilters($filters = null): ?array
    {
        $filter = [
            "first_name" => null,
            "last_name" => null,
            "cpf_cnpj" => null,
            "email" => null,
            "city" => null,
            "state" => null,
            "zip" => null,
            "date_birth" => null,
        ];

        foreach ($filters as $keyFilter => $valueToFilter) {
            $filter[$keyFilter] = $valueToFilter;

            if (empty($valueToFilter)) {
                unset($filter[$keyFilter]);
            }
        }

        if (empty($filter) || empty($filters)) {
            return null;
        }

        return mountFilters($filter);
    }
}
