<?php

    namespace Theme\Pages\Publication;

    use Source\Models\Model;

    class PublicationModel extends Model
    {
        public function __construct()
        {
            $this->setTable("publications");

            parent::__construct("publications", ["title", "slug", "description"]);
        }
    }