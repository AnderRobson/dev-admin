<?php

    namespace Theme\Pages\Publication;

    use CoffeeCode\DataLayer\DataLayer;

    class PublicationModel extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("users", ["first_name", "last_name"]);
        }
    }