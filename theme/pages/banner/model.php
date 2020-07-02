<?php

    namespace Theme\Pages\Banner;

    use Source\Models\Model;

    class BannerModel extends Model
    {
        public function __construct()
        {
            parent::__construct("banners", ["title", "slug", "description"]);
        }
    }