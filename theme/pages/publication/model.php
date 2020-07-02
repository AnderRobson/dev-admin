<?php

    namespace Theme\Pages\Publication;

    use Source\Models\Model;

    class PublicationModel extends Model
    {
        public function __construct()
        {
            parent::__construct("publications", ["title", "slug", "description"]);
        }
    }