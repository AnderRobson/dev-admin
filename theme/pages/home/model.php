<?php

    namespace Theme\pages\home;

    use CoffeeCode\DataLayer\DataLayer;

    class User extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("users", ["first_name", "last_name"]);
        }
    }