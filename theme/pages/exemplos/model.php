<?php

    namespace Theme\Pages\Home;

    use CoffeeCode\DataLayer\DataLayer;

    class UserModel extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("users", ["first_name", "last_name"]);
        }
    }