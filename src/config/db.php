<?php
    class db{
        //Propiedades
        private $dbhost = 'localhost';
        private $dbuser = 'root';
        private $dbpass = 'root';
        private $dbname = 'slim';

        //Conexion
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost; dbname=$this->dbname";
            $db_connection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db_connection;
        }
        
    }