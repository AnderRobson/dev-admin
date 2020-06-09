<?php

    namespace Theme\Pages\Exemplos;

    use CoffeeCode\DataLayer\DataLayer;

    class ExemplosModel extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("users", ["name"]);
        }
    }