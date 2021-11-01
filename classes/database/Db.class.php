<?php

    class Db {
        private $dbHost = "localhost";
        private $dbName = "gmae";
        private $dbUser = "root";
        private $dbPass = "";

        // private $dbHost = "localhost";
        // private $dbName = "gmaenetw_db";
        // private $dbUser = "gmaenetw_user";
        // private $dbPass = "@GNetwork*1";

        protected function conn(){
            $conn = new PDO('mysql:host='.$this->dbHost.'; dbname='.$this->dbName, $this->dbUser, $this->dbPass);
            return $conn;
        }
    }