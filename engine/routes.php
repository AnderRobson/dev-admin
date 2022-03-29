<?php
    use CoffeeCode\Router\Router;

    $router = new Router(URL_BASE);

    $router->group(null);

    /**
     * Setando Controllers
     */
    $router->namespace("Source\Controllers");

    $router->get("/", "Web:home");

    $router->get("{slug_post}", "Web:slugPost");
    $router->get("pages/{page}", "Web:pages");
    $router->get("pages/{page}/{function}", "Web:pages");
    $router->get("pages/{page}/{function}/{slug}", "Web:pages");
    $router->post("pages/{page}/{function}", "Web:pages");
    $router->post("pages/{page}/{function}/{slug}", "Web:pages");
    $router->post("delete", "Web:delete", 'form.delete');
    $router->get("banner", "Web:banner");

    $router->get("login", "Web:login", "Web.login");
    $router->post("login", "Web:login", "Web.login");
    $router->get("register", "Web:register", "Web.register");
    $router->post("register", "Web:register", "Web.register");
    $router->get("forget", "Web:forget", "Web.forget");
    $router->post("forget", "Web:forget", "Web.forget");
    $router->get("reset/{email}/{forget}", "Web:reset", "Web.reset");
    $router->post("reset", "Web:resetPassword", "Web.resetPassword");
    $router->get("sair", "Web:logoff", "Web.logoff");

    /**
     * Redes sociais
     */
    $router->group(null);

    $router->get("facebook", "Web:facebook", "Web.facebook");
    $router->get("google", "Web:google", "Web.google");


    /**
     *  APIs Restful
     */
    $router->get('webservice/{function}', "Api:get");
    $router->post("webservice/{function}", "Api:post");

    /**
     * Group Error
     * This monitors all Router errors. Are they: 400 Bad Request, 404 Not Found, 405 Method Not Allowed and 501 Not Implemented
     */
    $router->get("ooops/{errcode}", "Web:error");

    /**
     * This method executes the routes
     */
    $router->dispatch();

    /*
     * Redirect all errors
     */
    if ($router->error()) {
        $router->redirect("/ooops/{$router->error()}");
    }
