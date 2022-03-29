<?php


namespace Theme\Pages\Person;


use Source\Controllers\Controller;
use Theme\Pages\Address\AddressModel;

/**
 * Class PersonController
 *
 * @package Theme\Pages\Person
 */
class PersonController extends Controller
{
    public function index(array $filters = null): void
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/person"),
            ""
        )->render();

        $persons = (new PersonModel())->getAllInformationFromPersons();

        echo $this->view->render("person/view/index", [
            "persons" => $persons,
            "states" => (new AddressModel())->getAllState(),
            "head" => $head
        ]);
    }

    private function setFilters($filters = null): ?array
    {
        if (empty($filters)) {
            return null;
        }

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

        if (empty($filter)) {
            return null;
        }

        return mountFilters($filter);
    }

    public function edit($data = null)
    {
        $head = $this->seo->optimize(
            "Bem vindo ao " . SITE["SHORT_NAME"],
            SITE["DESCRIPTION"],
            url("pages/person/edit"),
            ""
        )->render();

        $person = (new PersonModel())->getAllInformationFromPersonById($data["slug"]);

        echo $this->view->render("person/view/edit", [
            "person" => $person,
            "head" => $head
        ]);
    }
}
