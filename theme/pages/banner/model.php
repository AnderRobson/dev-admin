<?php

    namespace Theme\Pages\Banner;

    use CoffeeCode\DataLayer\DataLayer;

    class BannerModel extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("banners", ["title", "slug", "description"]);
        }
    }