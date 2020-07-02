<?php


namespace Theme\pages\person;


use Source\Controllers\Controller;

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

    public function index(): void
    {
        printrx("Construindo listagem de usuários");
    }
}
