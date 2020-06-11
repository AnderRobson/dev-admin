<?php

    namespace Source\Controllers;

    class Api
    {
        public function getPosts($data)
        {
            echo json_encode($data);
            return;
        }

        public function getPost($data)
        {
            echo json_encode($data);
            return;
        }
    }