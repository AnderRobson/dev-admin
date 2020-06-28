<?php

    /**
     * Database config
     */
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => DATABASE["HOST"],
        "port" => DATABASE["PORT"],
        "dbname" => DATABASE["DBNAME"],
        "username" => DATABASE["USER"],
        "passwd" => DATABASE["PASSWORD"],
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND  => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);

    /**
     *  Social login: Facebook
     */
    define("FCEBOOK_LOGIN", []);

    /**
     *  Social login: Google
     */
    define("GOOGLE_LOGIN", []);